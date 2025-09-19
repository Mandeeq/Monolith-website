<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use qaffee\models\Blogs;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */

// Fetch published blog posts with pagination
$blogs = Blogs::find()
    // ->where(['status' => 'published'])
    ->orderBy(['published_at' => SORT_DESC])
    ->all();

// Fetch recent posts for the sidebar (e.g., latest 4 published posts)
$recentPosts = Blogs::find()
    ->where(['status' => 'published'])
    ->orderBy(['published_at' => SORT_DESC])
    ->limit(4)
    ->all();
?>

<section class="blog_area section_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="blog_left_sidebar">
                    <?php foreach ($blogs as $blog): ?>
                        <article class="blog_item">
                            <div class="blog_item_img">
                                <?php
                                // Construct image path; fallback to placeholder if no image
                                $imagePath = $blog->image ? Yii::getAlias('@web') . '/' . $blog->image : '@web/web/assets/img/blog/placeholder.png';
                                ?>
                                <?= Html::img($imagePath, [
                                    'class' => 'card-img rounded-0',
                                    'alt' => Html::encode($blog->title)
                                ]) ?>
                                <a href="<?= Yii::$app->urlManager->createUrl(['blog/view']) ?>" class="blog_item_date">
                                    <h3><?= date('d', strtotime($blog->published_at)) ?></h3>
                                    <p><?= date('M', strtotime($blog->published_at)) ?></p>
                                </a>
                            </div>
                            <div class="blog_details">
                                <a class="d-inline-block" href="<?= Yii::$app->urlManager->createUrl(['blog/view']) ?>">
                                    <h2><?= Html::encode($blog->title) ?></h2>
                                </a>
                                <p>
                                    <?= Html::encode(StringHelper::truncate($blog->content, 150, '...')) ?>
                                </p>
                                <ul class="blog-info-link">
                                    <li>
                                        <a href="#"><i class="far fa-user"></i> Blog</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="far fa-comments"></i> 0 Comments</a>
                                    </li>
                                </ul>
                            </div>
                        </article>
                    <?php endforeach; ?>

                    <!-- Pagination -->
                    <?php /*
                    echo LinkPager::widget([
                        'pagination' => $pagination,
                        'prevPageLabel' => '<i class="ti-angle-left"></i>',
                        'nextPageLabel' => '<i class="ti-angle-right"></i>',
                        'maxButtonCount' => 5,
                        'options' => ['class' => 'blog-pagination justify-content-center d-flex'],
                        'linkContainerOptions' => ['class' => 'page-item'],
                        'linkOptions' => ['class' => 'page-link'],
                        'activePageCssClass' => 'active',
                    ]);
                    */ ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="blog_right_sidebar">
                    <!-- Search Widget -->
                    <aside class="single_sidebar_widget search_widget">
                        <form action="#">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Search Keyword"
                                        onfocus="this.placeholder = ''"
                                        onblur="this.placeholder = 'Search Keyword'"
                                    />
                                    <div class="input-group-append">
                                        <button class="btn" type="button">
                                            <i class="ti-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button
                                class="button rounded-0 primary-bg text-white w-100 btn_4"
                                type="submit"
                            >
                                Search
                            </button>
                        </form>
                    </aside>

                    <!-- Category Widget (Static for now) -->
                    <aside class="single_sidebar_widget post_category_widget">
                        <h4 class="widget_title">Category</h4>
                        <ul class="list cat-list">
                            <li>
                                <a href="#" class="d-flex">
                                    <p>Restaurant food</p>
                                    <p>(37)</p>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="d-flex">
                                    <p>Travel news</p>
                                    <p>(10)</p>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="d-flex">
                                    <p>Modern technology</p>
                                    <p>(03)</p>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="d-flex">
                                    <p>Product</p>
                                    <p>(11)</p>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="d-flex">
                                    <p>Inspiration</p>
                                    <p>(21)</p>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="d-flex">
                                    <p>Health Care</p>
                                    <p>(09)</p>
                                </a>
                            </li>
                        </ul>
                    </aside>

                    <!-- Recent Posts Widget -->
                    <aside class="single_sidebar_widget popular_post_widget">
                        <h3 class="widget_title">Recent Post</h3>
                        <?php foreach ($recentPosts as $post): ?>
                            <div class="media post_item">
                                <?= Html::img($post->image ? Yii::getAlias('@web') . '/' . $post->image : '@web/web/assets/img/blog/placeholder.png', [
                                    'alt' => Html::encode($post->title)
                                ]) ?>
                                <div class="media-body">
                                    <a href="<?= Yii::$app->urlManager->createUrl(['blog/view', 'slug' => $post->slug]) ?>">
                                        <h3><?= Html::encode(StringHelper::truncate($post->title, 25, '...')) ?></h3>
                                    </a>
                                    <p><?= date('F d, Y', strtotime($post->published_at)) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </aside>

                    <!-- Tag Cloud Widget (Static for now) -->
                    <aside class="single_sidebar_widget tag_cloud_widget">
                        <h4 class="widget_title">Tag Clouds</h4>
                        <ul class="list">
                            <li><a href="#">project</a></li>
                            <li><a href="#">love</a></li>
                            <li><a href="#">technology</a></li>
                            <li><a href="#">travel</a></li>
                            <li><a href="#">restaurant</a></li>
                            <li><a href="#">life style</a></li>
                            <li><a href="#">design</a></li>
                            <li><a href="#">illustration</a></li>
                        </ul>
                    </aside>

                    <!-- Instagram Feeds Widget (Static for now) -->
                    <aside class="single_sidebar_widget instagram_feeds">
                        <h4 class="widget_title">Instagram Feeds</h4>
                        <ul class="instagram_row flex-wrap">
                            <li>
                                <a href="#">
                                    <img class="img-fluid" src="/e-comerce/e-commerce-app/web/assets/img/post/post_5.png" alt="" />
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="img-fluid" src="/e-comerce/e-commerce-app/web/assets/img/post/post_6.png" alt="" />
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="img-fluid" src="/e-comerce/e-commerce-app/web/assets/img/post/post_7.png" alt="" />
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="img-fluid" src="/e-comerce/e-commerce-app/web/assets/img/post/post_8.png" alt="" />
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="img-fluid" src="/e-comerce/e-commerce-app/web/assets/img/post/post_9.png" alt="" />
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="img-fluid" src="/e-comerce/e-commerce-app/web/assets/img/post/post_10.png" alt="" />
                                </a>
                            </li>
                        </ul>
                    </aside>

                    <!-- Newsletter Widget (Static for now) -->
                    <aside class="single_sidebar_widget newsletter_widget">
                        <h4 class="widget_title">Newsletter</h4>
                        <form action="#">
                            <div class="form-group">
                                <input
                                    type="email"
                                    class="form-control"
                                    onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Enter email'"
                                    placeholder="Enter email"
                                    required
                                />
                            </div>
                            <button
                                class="button rounded-0 primary-bg text-white w-100 btn_4"
                                type="submit"
                            >
                                Subscribe
                            </button>
                        </form>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.blog_area {
    padding: 50px 0;
}
.blog_item {
    margin-bottom: 30px;
}
.blog_item_img {
    position: relative;
}
.blog_item_img img {
    width: 100%;
    height: 250px;
    object-fit: cover;
}
.blog_item_date {
    position: absolute;
    bottom: -20px;
    left: 20px;
    background: #e74c3c;
    color: #fff;
    padding: 10px;
    text-align: center;
    border-radius: 5px;
}
.blog_item_date h3 {
    font-size: 24px;
    margin: 0;
}
.blog_item_date p {
    margin: 0;
    font-size: 14px;
}
.blog_details {
    padding: 20px;
    background: #f9f9f9;
    border-radius: 0 0 5px 5px;
}
.blog_details h2 {
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 10px;
}
.blog_details p {
    font-size: 14px;
    color: #666;
    margin-bottom: 15px;
}
.blog-info-link {
    list-style: none;
    padding: 0;
    display: flex;
    gap: 20px;
}
.blog-info-link li a {
    font-size: 14px;
    color: #777;
}
.blog_right_sidebar .single_sidebar_widget {
    margin-bottom: 30px;
    background: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
.widget_title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 20px;
}
.post_item img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    margin-right: 15px;
}
.post_item .media-body h3 {
    font-size: 14px;
    margin-bottom: 5px;
}
.post_item .media-body p {
    font-size: 12px;
    color: #777;
}
@media (max-width: 767px) {
    .blog_item_img img {
        height: 200px;
    }
    .blog_details {
        padding: 15px;
    }
}
</style>