# Blog-Api-Laravel

This project is a robust and feature-rich RESTful API developed using the Laravel framework, designed to serve as the backend for a modern blog management system. It provides all the essential endpoints required for managing a blog while maintaining a flexible and scalable architecture for future enhancements.

Key Features:
- Post Management:
    - Full CRUD (Create, Read, Update, Delete) functionality for blog posts.
    - Support for managing titles, content, featured images, and publishing status.
- Category and Tag Management:
    - Endpoints for creating, updating, and organizing categories and tags to structure blog content effectively.
- User Roles and Permissions:
    - Role-based access control for Admins, Editors, and Authors.
    - Secure authentication and authorization using Laravel's built-in features.
- Comments Management:
    - API endpoints to manage comments, including moderation, approval, and deletion.
- SEO Support (coming soon):
    - Features for managing meta tags, descriptions, and URLs for SEO optimization.
- JSON Responses:
    - Consistent and structured JSON responses for seamless integration with frontend frameworks or third-party applications.

Built with Laravel:
- RESTful Architecture:
    - Follows RESTful principles for clean and predictable endpoints.
- Scalable and Secure:
    - Leverages Laravel’s robust security features, including CSRF protection, validation, and middleware.
- Expandable Design:
    - Easily extensible to integrate additional features such as analytics, third-party APIs, or advanced search.
  
This API project is perfect for developers building a frontend application or mobile app for a blog platform. It provides a strong foundation for modern blog systems, whether it’s a personal blog, multi-author platform, or corporate news website.

## Technologies (languages & frameworks)

- Php
- Laravel
- MySql

## Packages & Libraries

- Sanctum
- L5-Swagger

## Setup

1. Install Php Packages
```sh
composer install
```
2. Create .env File
```sh
1. duplicate the ".env.example" in main folder
2. rename the file you copied to ".env"
3. configure the ".env" file you renamed
```
3. Create App Key
```sh
php artisan key:generate
```
4. Run Migrations
```sh
php artisan migrate
```
5. Run Seeders (For Test Datas)
```sh
php artisan db:seed
```
6. Run Laravel Project
```sh
php artisan serve
```

## Admin User Credentials

-   Email: blogadmin@blogadmin.com
-   Password: password

## Author User Credentials

-   Email: blogauthor@blogauthor.com
-   Password: password

## Reader User Credentials

-   Email: blogreader@blogreader.com
-   Password: password

## Endpoints

- Auth
  - Login
  - Register
    - Admin
    - Auth
    - Reader
  - Logout
- Users
  - List
  - Create
  - Show
  - Update
  - Delete
- Posts
  - List
  - Create
  - Show
  - Update
  - Delete
  - Publisheds
  - Drafts
  - Archived
  - Populars
  - Recents
  - Relateds
  - Comments
- Comments
  - List
  - Create
  - Show
  - Update
  - Delete
  - Recent
  - Approve
  - Reject
- Categories
  - List
  - Create
  - Show
  - Update
  - Delete
  - Parent
  - Subs
  - Posts
- Post Views
  - List
  - Create
  - Show
  - Most Vieweds
- Roles
  - List
  - Create
  - Show
  - Update
  - Delete
  - Role Users
  - Role Users Count
- Tags
  - List
  - Create
  - Show
  - Update
  - Delete
  - Popular
  - Tag Posts
- User Follows
  - Follow
  - UnFollow
  - Followers
  - Followings
