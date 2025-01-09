<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\User;
use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\Services\UserServiceInterface;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    protected function createUser(RegisterRequest $request, string $roleName): JsonResponse
    {
        $role = Role::where('name', $roleName)->firstOrFail();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
            'occupation' => $request->occupation,
            'date_of_birth' => $request->date_of_birth,
            'location' => $request->location,
            'preferred_language' => $request->preferred_language,
            'gender' => $request->gender,
            'bio' => $request->bio
        ]);

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $user->profile_picture = $path;
            $user->save();
        }

        $user->interests()->attach($request->interests);

        $token = $user->createToken('auth_token')->plainTextToken;

        return ResponseHelper::created(["user" => $user, "token" => $token]);
    }

    /**
     * @OA\Post(
     *     path="/auth/register/admin",
     *     tags={"Kimlik Doğrulama"},
     *     summary="Admin kaydı",
     *     description="Yeni bir admin kullanıcısı oluşturur",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserRegistration")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Başarılı kayıt",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Kayıt başarılı"),
     *             @OA\Property(property="user", ref="#/components/schemas/User"),
     *             @OA\Property(property="token", type="string")
     *         )
     *     ),
     *     @OA\Response(response=422, ref="#/components/responses/ValidationError")
     * )
     */
    public function registerAdmin(RegisterRequest $request): JsonResponse
    {
        return $this->createUser($request, Role::ADMIN);
    }

    /**
     * @OA\Post(
     *     path="/auth/register/author",
     *     tags={"Kimlik Doğrulama"},
     *     summary="Yazar kaydı",
     *     description="Yeni bir yazar kullanıcısı oluşturur",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserRegistration")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Başarılı kayıt",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Kayıt başarılı"),
     *             @OA\Property(property="user", ref="#/components/schemas/User"),
     *             @OA\Property(property="token", type="string")
     *         )
     *     ),
     *     @OA\Response(response=422, ref="#/components/responses/ValidationError")
     * )
     */
    public function registerAuthor(RegisterRequest $request): JsonResponse
    {
        return $this->createUser($request, Role::AUTHOR);
    }

    /**
     * @OA\Post(
     *     path="/auth/register/reader",
     *     tags={"Kimlik Doğrulama"},
     *     summary="Okuyucu kaydı",
     *     description="Yeni bir okuyucu kullanıcısı oluşturur",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserRegistration")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Başarılı kayıt",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Kayıt başarılı"),
     *             @OA\Property(property="user", ref="#/components/schemas/User"),
     *             @OA\Property(property="token", type="string")
     *         )
     *     ),
     *     @OA\Response(response=422, ref="#/components/responses/ValidationError")
     * )
     */
    public function registerReader(RegisterRequest $request): JsonResponse
    {
        return $this->createUser($request, Role::READER);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Kullanıcı girişi",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı giriş",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Logged in successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="user", type="object"),
     *                 @OA\Property(property="token", type="string")
     *             )
     *         )
     *     )
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return ResponseHelper::unauthorized('Invalid login credentials');
            }

            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return ResponseHelper::success([
                'user' => $user,
                'token' => $token
            ], 'Logged in successfully');
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Kullanıcı çıkışı",
     *     tags={"Authentication"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı çıkış",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Logged out successfully")
     *         )
     *     )
     * )
     */
    public function logout(): JsonResponse
    {
        try {
            Auth::user()->tokens()->delete();
            return ResponseHelper::success(null, 'Logged out successfully');
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }
}
