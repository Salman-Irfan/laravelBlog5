All the public and protected routes were defined in 
/routes/api.php

database migration files were
1. users
2. blogs -> with foreign key of users
3. comments -> with foreign key of blogs

Controllers were defined in /app/http/controllers/api/
1. UserController
2. AdminUserController
3. BlogController
4. CommentController

Routes are
1. user can register / login / comment / delete its accoutn
2. admin can change the status of blog, user role, view all registered users
3. guest can only read blogs, and write comments only
