<?php

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Blog Yönetim Sistemi API Dokümantasyonu",
 *     description="Blog yönetim sistemi için RESTful API dokümantasyonu",
 *     @OA\Contact(
 *         email="admin@example.com"
 *     )
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="Yerel Geliştirme Sunucusu"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * 
 * @OA\Tag(
 *     name="Kimlik Doğrulama",
 *     description="Kimlik doğrulama işlemleri için endpoint'ler"
 * )
 * 
 * @OA\Tag(
 *     name="Kullanıcı",
 *     description="Kullanıcı profili yönetimi için endpoint'ler"
 * )
 * 
 * @OA\Tag(
 *     name="Blog",
 *     description="Blog yazıları yönetimi için endpoint'ler"
 * )
 * 
 * @OA\Tag(
 *     name="Yorum",
 *     description="Yorum yönetimi için endpoint'ler"
 * )
 * 
 * @OA\Tag(
 *     name="Takip",
 *     description="Yazar takip sistemi için endpoint'ler"
 * )
 * 
 * @OA\Tag(
 *     name="Admin",
 *     description="Admin işlemleri için endpoint'ler"
 * )
 * 
 * @OA\Schema(
 *     schema="Error",
 *     @OA\Property(property="message", type="string", example="Hata mesajı"),
 *     @OA\Property(
 *         property="errors",
 *         type="object",
 *         @OA\AdditionalProperties(
 *             type="array",
 *             @OA\Items(type="string")
 *         )
 *     )
 * )
 * 
 * @OA\Schema(
 *     schema="ValidationError",
 *     @OA\Property(property="message", type="string", example="Validasyon hatası"),
 *     @OA\Property(
 *         property="errors",
 *         type="object",
 *         @OA\AdditionalProperties(
 *             type="array",
 *             @OA\Items(type="string")
 *         )
 *     )
 * )
 * 
 * @OA\Schema(
 *     schema="User",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="email", type="string"),
 *     @OA\Property(property="profile_picture", type="string", nullable=true),
 *     @OA\Property(property="occupation", type="string"),
 *     @OA\Property(property="date_of_birth", type="string", format="date"),
 *     @OA\Property(property="location", type="string"),
 *     @OA\Property(property="preferred_language", type="string", enum={"tr", "en"}),
 *     @OA\Property(property="gender", type="string", enum={"male", "female", "other", "prefer_not_to_say"}),
 *     @OA\Property(property="bio", type="string", nullable=true),
 *     @OA\Property(property="role", type="object", ref="#/components/schemas/Role"),
 *     @OA\Property(property="interests", type="array", @OA\Items(ref="#/components/schemas/Tag"))
 * )
 * 
 * @OA\Schema(
 *     schema="Role",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string", enum={"admin", "author", "reader"}),
 *     @OA\Property(property="description", type="string")
 * )
 * 
 * @OA\Schema(
 *     schema="Post",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="slug", type="string"),
 *     @OA\Property(property="content", type="string"),
 *     @OA\Property(property="status", type="string", enum={"draft", "published"}),
 *     @OA\Property(property="views_count", type="integer"),
 *     @OA\Property(property="author", type="object", ref="#/components/schemas/User"),
 *     @OA\Property(property="category", type="object", ref="#/components/schemas/Category"),
 *     @OA\Property(property="tags", type="array", @OA\Items(ref="#/components/schemas/Tag"))
 * )
 * 
 * @OA\Schema(
 *     schema="Comment",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="content", type="string"),
 *     @OA\Property(property="status", type="string", enum={"approved", "rejected", "pending"}),
 *     @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
 *     @OA\Property(property="post", type="object", ref="#/components/schemas/Post"),
 *     @OA\Property(property="parent_id", type="integer", nullable=true),
 *     @OA\Property(property="replies", type="array", @OA\Items(ref="#/components/schemas/Comment"))
 * )
 * 
 * @OA\Schema(
 *     schema="Category",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="slug", type="string"),
 *     @OA\Property(property="description", type="string", nullable=true)
 * )
 * 
 * @OA\Schema(
 *     schema="Tag",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="slug", type="string")
 * )
 */ 