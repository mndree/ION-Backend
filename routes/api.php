<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SubTopicController;
use App\Http\Controllers\AdminApprovalController;
use App\Http\Controllers\AdminNewsApprovalController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::get("/token", function (Request $request) {
    return $request->session()->token();
});

// Route::put('/register/approve/{user_id}', [UserController::class, "approve"]);

// Users
Route::post("user/profile/{user_id}", [UserController::class, "updateUser"]); //update news
Route::get("userprofile/{id}", [UserController::class, "userProfile"]);
Route::post('/login/admin', [UserController::class, "loginAdmin"]);
Route::post('/login/user', [UserController::class, "loginUser"]);
Route::post("user/register", [UserController::class, "register"]);
Route::post('/registeradmin', [UserController::class, 'registerAdmin']);
Route::get("/authors", [UserController::class, "showAllAuthors"]);
// News Routes
Route::get("news/topics", [NewsController::class, "showNewsByTopics"]);
Route::get("news/topics/{topic_slug}", [NewsController::class, "showNewsByTopic"]); //Show news by a topic
Route::get("news/topics/sub_topics/{sub_topic_slug}", [NewsController::class, "showNewsBySubTopicsAndTopics"]);
Route::get("news/topics/{topic_id}/sub_topics/{sub_topic_id}/news/{news_title}", [NewsController::class, "readingNews"]);
Route::get("news/topics/user/{id}", [NewsController::class, "showNewsByUserId"]);
Route::get("news", [NewsController::class, "index"]);
Route::post("news/{news_id}", [NewsController::class, "updateNews"]);
Route::delete("news/{news_id}", [NewsController::class, "delete"]);

Route::get("/sub_topics", [SubTopicController::class, "index"]);
Route::get("/sub_topics{sub_topic_slug}", [SubTopicController::class, "show"]);
Route::post("/sub_topics", [SubTopicController::class, "store"]);
Route::post("/sub_topics/{id}", [SubTopicController::class, "update"]);
Route::delete("/sub_topics/{id}", [SubTopicController::class, "delete"]);
Route::get("/topics", [TopicController::class, "index"]);
Route::get("/topics/{topic_slug}", [TopicController::class, "show"]);
Route::post("/topics", [TopicController::class, "save"]);
Route::post("/topics/{id}", [TopicController::class, "update"]);
Route::delete("/topics/{id}", [TopicController::class, "delete"]);
Route::get("/history/{id?}", [HistoryController::class, "index"]);
Route::post("/history", [HistoryController::class, "store"]);
Route::delete("/history/{id}", [HistoryController::class, "delete"]);


Route::post("/logout", [AuthController::class, "signout"]);

// Admin Approval Routes
Route::get("/adminapproval/author", [AdminApprovalController::class, "listAdminApproval"]);
Route::post("/adminapproval/author/{id}", [AdminApprovalController::class, "makeApproval"]);
Route::prefix("adminapproval/author")->group(function () {
    route::post("/approve/{id}", [AuthorController::class, "approve"]);
    route::post("reject/{id}", [AuthorController::class, "reject"]);
});
Route::get("/adminapproval/news", [AdminNewsApprovalController::class, "showAdminNewsApproval"]);
Route::post("/adminapproval/news/{user_id}", [AdminNewsApprovalController::class, "makeApproval"]);
Route::post("/adminapproval/news/balance/{user_id}", [AdminNewsApprovalController::class, "updateBalance"]);
Route::prefix("adminapproval/news")->group(function () {
    route::post("approve/{news_title}", [NewsController::class, "approve"]);
    route::post("reject/{news_title}", [NewsController::class, "reject"]);
});
Route::middleware("auth:sanctum")->group(function () {
});
