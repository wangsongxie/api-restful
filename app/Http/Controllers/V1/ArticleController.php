<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/22
 * Time: 12:57
 */
namespace App\Http\Controllers\V1;


use App\Article;
use App\ArticleCategory;
use App\ArticleComment;
use App\DogsCategory;
use App\Http\Requests\IdRequest;
use App\Repsitories\ArticleCategoryResitory;
use App\Repsitories\ArticleResitory;
use App\Requests\ArticleCommentAddRequest;
use App\Transformers\CommentsTransformer;
use Illuminate\Http\Request;

class ArticleController extends BaseController
{
    protected $article ;

    protected $category ;

    public function __construct(ArticleCategoryResitory $articleCategoryResitory , ArticleResitory $articleResitory)
    {
        $this->article = $articleResitory ;
        $this->category = $articleCategoryResitory ;
    }

    /**
     * @SWG\Get(
     *      path="/article/baike",
     *      tags={"guest"},
     *      operationId="article.baike",
     *      summary="百科首页",
     *      description="<img src='https://attachments.tower.im/tower/7e2236d4d6854cf782d6ece5a8903f15?filename=%E7%8B%97%E7%8B%97%E7%99%BE%E7%A7%91.png'>",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="结果集",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="integer", description="状态码"),
     *              @SWG\Property(property="message", type="string", description="状态信息"),
     *              @SWG\Property(property="cate", type="object",
     *                  ref="#/definitions/marticle_category"
     *              ),@SWG\Property(property="dog", type="object",
     *                  ref="#/definitions/mdog_category"
     *              ),
     *          )
     *      ),
     * )
     */
    public function baike()
    {
        $cate =  $this->category->getIndex();
        $dog = DogsCategory::all();
        return $this->success(compact('cate','dog'));
    }


    /**
     * @SWG\Get(
     *      path="/article/second_category",
     *      tags={"guest"},
     *      operationId="article.second_category",
     *      summary="获取文章二级分类列表",
     *      description="<img src='https://attachments.tower.im/tower/87fa1174aae74501b51ac448103c3242?version=auto&filename=image.png'>",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          in="query",
     *          name="id",
     *          description="一级分类id 2",
     *          required=false,
     *          type="string",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="id",
     *                  type="string",
     *                  description="一级分类id 2",
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="结果集",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="integer", description="状态码"),
     *              @SWG\Property(property="message", type="string", description="状态信息"),
     *              @SWG\Property(property="cate", type="object",
     *                  ref="#/definitions/marticle_category"
     *              )
     *          )
     *      ),
     * )
     */
    public function articleSecondCategory(IdRequest $request)
    {
        $pid = $request->input("id");
        if(!is_numeric($pid))
        {
            return $this->failed("fail");
        }
        return $this->success($this->category->getSecondCategory($pid));
    }
    /**
     * @SWG\Get(
     *      path="/article/list",
     *      tags={"guest"},
     *      operationId="article.articles",
     *      summary="文章列表",
     *      description="<img src='https://attachments.tower.im/tower/1d3068ed504b473abc00b19f865f352e?version=auto&filename=image.png'>",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          in="query",
     *          name="id",
     *          description="分类编号",
     *          required=false,
     *          type="string",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="id",
     *                  type="string",
     *                  description="分类编号",
     *              )
     *          )
     *      ),@SWG\Parameter(
     *          in="query",
     *          name="keywords",
     *          description="关键词",
     *          required=false,
     *          type="string",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="keywords",
     *                  type="string",
     *                  description="关键词",
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="结果集",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="integer", description="状态码"),
     *              @SWG\Property(property="message", type="string", description="状态信息"),
     *              @SWG\Property(property="data", type="object",
     *                  ref="#/definitions/marticle"
     *              )
     *          )
     *      ),
     * )
     */
    public function articleList(IdRequest $request)
    {
        $id = $request->get("id", 0);
        $keywords = $request->input("keywords", null);
        if(!is_numeric($id))
        {
            return $this->failed("fail");
        }
        return $this->success($this->article->getArticleList($id , $keywords));
    }

    /**
     * @SWG\Get(
     *      path="/article/detail",
     *      tags={"guest"},
     *      operationId="article.detail",
     *      summary="文章详情",
     *      description="<img src='https://attachments.tower.im/tower/e871650bd31c4fc2a39c5273df1bf3ff?version=auto&filename=image.png'>",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          in="query",
     *          name="id",
     *          description="文章编号",
     *          required=false,
     *          type="string",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="id",
     *                  type="string",
     *                  description="文章编号, 30有数据",
     *              )
     *          )
     *      ),
     *     @SWG\Parameter(
     *          in="query",
     *          name="page",
     *          description="页码",
     *          required=false,
     *          type="string",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="page",
     *                  type="string",
     *                  description="页码",
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="结果集",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="integer", description="状态码"),
     *              @SWG\Property(property="message", type="string", description="状态信息"),
     *              @SWG\Property(property="detail", type="object",
     *                  ref="#/definitions/marticle"
     *              )
     *          )
     *      ),
     * )
     */
    public function detail(IdRequest $request)
    {
        $id = $request->input("id");
        $article = $this->article->find($id);
        return $this->success(['detail' => $article]);
    }

    /**
     * @SWG\Post(
     *      path="/article/like",
     *      tags={"auth"},
     *      operationId="article.like",
     *      summary="给文章点赞",
     *      description="<img src='https://attachments.tower.im/tower/89c2f05d3655422c83f8aadba8dcca76?version=auto&filename=image.png'>",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
     *     @SWG\Parameter(
     *          in="query",
     *          name="id",
     *          description="data",
     *          required=false,
     *          type="string",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="id",
     *                  type="string",
     *                  description="文章编号,如果已经点赞了则会取消点赞",
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="结果集",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="integer", description="状态码"),
     *              @SWG\Property(property="message", type="string", description="状态信息"),
     *              @SWG\Property(property="like", type="boolean",description="ture or false")
     *          )
     *      ),
     * )
     */
    public function like(IdRequest $request)
    {
        $id = $request->input("id");
        $like = $this->article->likeArticle($id);
        return $this->success(['like' => $like]);
    }
    /**
     * @SWG\Post(
     *      path="/article/collect",
     *      tags={"auth"},
     *      operationId="article.collect",
     *      summary="文章收藏",
     *      description="<img src='https://attachments.tower.im/tower/32ce796700684835a42cf7febca63772?version=auto&filename=image.png' />",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={{"api_key": {"scope"}}},
     *     @SWG\Parameter(
     *          in="query",
     *          name="id",
     *          description="data",
     *          required=false,
     *          type="string",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="id",
     *                  type="string",
     *                  description="文章编号,如果已经收藏则会取消收藏",
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="结果集",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="integer", description="状态码"),
     *              @SWG\Property(property="message", type="string", description="状态信息"),
     *              @SWG\Property(property="collect", type="boolean",description="ture or false")
     *          )
     *      ),
     * )
     */
    public function collect(IdRequest $request)
    {
        $id = $request->input("id");
        $like = $this->article->collectArticle($id);
        return $this->success(['collect' => $like]);
    }



    /**
     * @SWG\Get(path="/article/{article_id}/comments",
     *      tags={"article"},
     *      summary="获取某个文章的评论",
     *      description="<img src='https://attachments.tower.im/tower/5d954567d47f4a03ae6a46c986937ca0?version=auto&filename=image.png'> <br/><br/><h1> 这个默认读取前三条，查看更多也调用此接口</h1>",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          description="文章id",
     *          in="path",
     *          name="article_id",
     *          required=true,
     *          type="integer",
     *          format="int64"
     *     ),
     *      @SWG\Response(
     *          response=200,
     *          description="请求成功",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="integer", description="状态码"),
     *              @SWG\Property(property="message", type="string", description="状态信息"),
     *              @SWG\Property(property="data", type="object",
     *                  @SWG\Property(property="total", type="integer", description="总条数"),
     *                  @SWG\Property(property="per_page", type="integer", description="每页显示数量"),
     *                  @SWG\Property(property="current_page", type="integer", description="当前页码"),
     *                  @SWG\Property(property="last_page", type="integer", description="最后一页"),
     *                  @SWG\Property(property="next_page_url", type="string", description="下一页地址"),
     *                  @SWG\Property(property="prev_page_url", type="string", description="上一页地址"),
     *                  @SWG\Property(property="from", type="integer", description="开始"),
     *                  @SWG\Property(property="to", type="integer", description="结束"),
     *                  @SWG\Property(property="lists", type="array",
     *                      @SWG\Items(type="object",
     *                          @SWG\Property(property="id", type="integer", description="评论id"),
     *                          @SWG\Property(property="article_id", type="integer", description="评论文章id"),
     *                          @SWG\Property(property="user_id", type="integer", description="评论用户id"),
     *                          @SWG\Property(property="content", type="string", description="评论内容"),
     *                          @SWG\Property(property="user", type="object",
     *                              @SWG\Property(property="id", type="integer", description="用户id"),
     *                              @SWG\Property(property="user_info", type="object",
     *                                  @SWG\Property(property="user_id", type="integer", description="用户id"),
     *                                  @SWG\Property(property="nickname", type="string", description="用户昵称"),
     *                                  @SWG\Property(property="headimgurl", type="string", description="用户头像"),
     *                              ),
     *                          ),
     *                      ),
     *
     *                  ),
     *              ),
     *          )
     *      )
     *   )
     */


    /**
     * @param $article_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function comments($article_id)
    {
        $comments = ArticleComment::with(['user' => function($query) {
            $query->with(['userInfo' => function ($query) {
                $query->select(['user_id', 'nickname', 'headimgurl']);
            }]);
        }])->where('article_id', $article_id)->paginate(10)->toArray();


        return $this->responseData(CommentsTransformer::transforms($comments));
    }


    /**
     * @SWG\Post(path="/article/comment/add",
     *      tags={"article"},
     *      summary="发布评论",
     *      description="发布评论",
     *      security={{"api_key": {"scope"}}},
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          in="body",
     *          name="body",
     *          description="data",
     *          required=true,
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="article_id",
     *                  type="integer",
     *                  description="文章id",
     *              ),
     *              @SWG\Property(
     *                  property="content",
     *                  type="string",
     *                  description="评论内容",
     *              ),
     *          )
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="返回数据",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="integer", description="状态码"),
     *              @SWG\Property(property="message", type="string", description="状态信息"),
     *          ),
     *      ),
     *
     *  )
     */


    public function commentAdd(ArticleCommentAddRequest $request)
    {

        $user = $request->user();
        $article_id = $request->get('article_id');
        $content = $request->get('content');

        $comment = ArticleComment::createComment([
            'user_id' => $user->id,
            'article_id' => $article_id,
            'content' => $content,
        ]);

        if ($comment) {
            return $this->responseSuccess();
        }

        return $this->responseFailed();
    }



    /**
     * @SWG\Get(
     *      path="/article/{article_id}/recommends",
     *      tags={"article"},
     *      operationId="article.recommends",
     *      summary="获取文章详情推荐文章",
     *      description="<img src='https://attachments.tower.im/tower/614c35b12aee4be887a00305e2b70338?version=auto&filename=image.png'>",
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          description="文章id",
     *          in="path",
     *          name="article_id",
     *          required=true,
     *          type="integer",
     *          format="int64"
     *     ),
     *      @SWG\Response(
     *          response=200,
     *          description="结果集",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="code", type="integer", description="状态码"),
     *              @SWG\Property(property="message", type="string", description="状态信息"),
     *              @SWG\Property(property="data", type="object",
     *                  @SWG\Property(property="cate_id", type="integer", description="分类id,用于查看更多使用"),
     *                  @SWG\Property(property="recommends", type="array",
     *                      @SWG\Items(
     *                          type="object",
     *                          @SWG\Property(property="id", type="integer", description="文章id"),
     *                          @SWG\Property(property="title", type="string", description="文章标题"),
     *                          @SWG\Property(property="thumb", type="string", description="文章缩略图"),
     *                          @SWG\Property(property="article_info", type="object",
     *                              @SWG\Property(property="desc", type="string", description="文章描述"),
     *                              @SWG\Property(property="article_id", type="integer", description="文章id"),
     *                          ),
     *                      ),
     *                  ),
     *              ),
     *          ),
     *      ),
     * )
     */

    /**
     * @param $article_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function recommendArticles($article_id)
    {
        $article = Article::find($article_id);

        if (!$article) {
            return $this->responseNotFound();
        }

        $recommends = Article::where(['cate_id' => $article->cate_id])->with(['articleInfo' => function($query) {

        }])
            ->select(['id', 'title', 'thumb'])->inRandomOrder()->limit(3)->get()->toArray();
        $cate_id =  $article->cate_id;
        return $this->responseData(compact('recommends', 'cate_id'));
    }
}
