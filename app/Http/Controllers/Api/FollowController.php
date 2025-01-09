<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * @OA\Post(
     *     path="/authors/{id}/follow",
     *     tags={"Takip"},
     *     summary="Yazarı takip et (Sadece Okuyucu)",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Yazar ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Yazar başarıyla takip edildi")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Kendini takip etme hatası"),
     *     @OA\Response(response=403, ref="#/components/responses/Forbidden"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFound")
     * )
     */
    public function follow($id)
    {
        $author = User::findOrFail($id);

        // Kendini takip etmeyi engelle
        if ($author->id === auth()->id()) {
            return response()->json([
                'message' => 'Kendinizi takip edemezsiniz'
            ], 400);
        }

        // Yazarı takip et
        auth()->user()->followedAuthors()->attach($author->id);

        return response()->json([
            'message' => 'Yazar başarıyla takip edildi'
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/authors/{id}/unfollow",
     *     tags={"Takip"},
     *     summary="Yazar takibini bırak (Sadece Okuyucu)",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Yazar ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Yazar takibi başarıyla kaldırıldı")
     *         )
     *     ),
     *     @OA\Response(response=403, ref="#/components/responses/Forbidden"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFound")
     * )
     */
    public function unfollow($id)
    {
        $author = User::findOrFail($id);

        // Takibi kaldır
        auth()->user()->followedAuthors()->detach($author->id);

        return response()->json([
            'message' => 'Yazar takibi başarıyla kaldırıldı'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/authors/{id}/followers",
     *     tags={"Takip"},
     *     summary="Yazarın takipçilerini listele (Sadece Yazar)",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Yazar ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Takipçiler başarıyla getirildi"),
     *             @OA\Property(
     *                 property="followers",
     *                 type="object",
     *                 @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/User")),
     *                 @OA\Property(property="current_page", type="integer"),
     *                 @OA\Property(property="last_page", type="integer"),
     *                 @OA\Property(property="per_page", type="integer"),
     *                 @OA\Property(property="total", type="integer")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=403, ref="#/components/responses/Forbidden"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFound")
     * )
     */
    public function followers($id)
    {
        $author = User::findOrFail($id);

        // Yetki kontrolü
        if ($author->id !== auth()->id() && !auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Bu işlem için yetkiniz bulunmamaktadır'
            ], 403);
        }

        $followers = $author->followers()->with('role')->paginate(15);

        return response()->json([
            'message' => 'Takipçiler başarıyla getirildi',
            'followers' => $followers
        ]);
    }

    /**
     * @OA\Get(
     *     path="/authors/following",
     *     tags={"Takip"},
     *     summary="Takip edilen yazarları listele",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Takip edilen yazarlar başarıyla getirildi"),
     *             @OA\Property(
     *                 property="following",
     *                 type="object",
     *                 @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/User")),
     *                 @OA\Property(property="current_page", type="integer"),
     *                 @OA\Property(property="last_page", type="integer"),
     *                 @OA\Property(property="per_page", type="integer"),
     *                 @OA\Property(property="total", type="integer")
     *             )
     *         )
     *     )
     * )
     */
    public function following(Request $request)
    {
        $following = auth()->user()->followedAuthors()
            ->with(['role', 'posts' => function($query) {
                $query->latest()->take(3);
            }])
            ->paginate(15);

        return response()->json([
            'message' => 'Takip edilen yazarlar başarıyla getirildi',
            'following' => $following
        ]);
    }
} 