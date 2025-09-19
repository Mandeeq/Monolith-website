<?php
use yii\helpers\Html;
use qaffee\models\MenuCategories;

/** @var yii\web\View $this */

// Fetch all menu categories with their food items, ordered by display_order
$categories = MenuCategories::find()
    ->with(['foodMenuses' => function($query) {
        $query->andWhere(['is_available' => 1])
              ->orderBy(['display_order' => SORT_ASC]);
    }])
    ->orderBy(['display_order' => SORT_ASC])
    ->all();
?>

<section class="food_menu">
    <div class="container">
        <?php foreach ($categories as $category): ?>
            <?php if (!empty($category->foodMenuses)): // Only display categories with available items ?>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <h2 class="category-title"><?= Html::encode($category->name) ?></h2>
                        <?php if ($category->description): ?>
                            <p class="category-description"><?= Html::encode($category->description) ?></p>
                        <?php endif; ?>
                        <div class="single-member">
                            <div class="row">
                                <?php foreach ($category->foodMenuses as $index => $food): ?>
                                    <div class="col-sm-6 col-lg-6">
                                        <div class="single_food_item media">
                                            <?php
                                            // Construct image path; fallback to placeholder if no image
                                            $imagePath = $food->image ? Yii::getAlias('@web') . $food->image : '@web/web/assets/img/food_menu/placeholder.png';
                                            ?>
                                            <?= Html::img($imagePath, [
                                                'class' => 'img-responsive',
                                                'alt' => Html::encode($food->name)
                                            ]) ?>
                                            <div class="media-body align-self-center">
                                                <h3><?= Html::encode($food->name) ?></h3>
                                                <?php if ($food->description): ?>
                                                    <p><?= Html::encode($food->description) ?></p>
                                                <?php endif; ?>
                                          
                                                <h5> From <?= Yii::$app->formatter->asCurrency($food->price) ?> </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($index % 2 == 1): // Start new row after every two items ?>
                                        </div><div class="row">
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</section>

<style>
.food_menu {
    padding: 50px 0;
}
.category-title {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 20px;
    text-align: center;
}
.category-description {
    font-size: 16px;
    color: #666;
    text-align: center;
    margin-bottom: 30px;
}
.single_food_item {
    margin-bottom: 30px;
    display: flex;
    align-items: center;
}
.single_food_item img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
    margin-right: 20px;
}
.media-body h3 {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 10px;
}
.media-body p {
    font-size: 14px;
    color: #777;
    margin-bottom: 10px;
}
.media-body h5 {
    font-size: 16px;
    font-weight: bold;
    color: #e74c3c;
}
@media (max-width: 767px) {
    .single_food_item {
        flex-direction: column;
        text-align: center;
    }
    .single_food_item img {
        margin-right: 0;
        margin-bottom: 15px;
    }
}
</style>