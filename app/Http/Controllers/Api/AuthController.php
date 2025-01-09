<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected function createUser(RegisterRequest $request, string $roleName)
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

        return response()->json([
            'message' => 'Kayıt başarılı',
            'user' => $user,
            'token' => $token
        ], 201);
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
    public function registerAdmin(RegisterRequest $request)
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
    public function registerAuthor(RegisterRequest $request)
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
    public function registerReader(RegisterRequest $request)
    {
        return $this->createUser($request, Role::READER);
    }

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     tags={"Kimlik Doğrulama"},
     *     summary="Kullanıcı girişi",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı giriş",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Giriş başarılı"),
     *             @OA\Property(property="user", ref="#/components/schemas/User"),
     *             @OA\Property(property="token", type="string")
     *         )
     *     ),
     *     @OA\Response(response=401, ref="#/components/responses/Unauthorized"),
     *     @OA\Response(response=422, ref="#/components/responses/ValidationError")
     * )
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Geçersiz kimlik bilgileri'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Giriş başarılı',
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     tags={"Kimlik Doğrulama"},
     *     summary="Kullanıcı çıkışı",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı çıkış",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="�ıkış başarılı")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Çıkış başarılı'
        ]);
    }
}
