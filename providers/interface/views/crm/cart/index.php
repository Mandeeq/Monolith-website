<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var crm\models\CartItems[] $cartItems */
/** @var float $total */

$this->title = 'My Cart';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container py-4">
    <h2 class="fw-bold mb-4"><?= Html::encode($this->title) ?></h2>

    <?php if (empty($cartItems)): ?>
        <div class="alert alert-info text-center">
            Your cart is empty.
        </div>
        <div class="text-center">
            <?= Html::a('Continue Shopping', ['product/index'], ['class' => 'btn btn-primary']) ?>
        </div>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($cartItems as $item): ?>
                <div class="list-group-item py-3">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-4">
                            <?php if (!empty($item->product->image)): ?>
                                <img src="<?= Html::encode($item->product->image) ?>" 
                                     class="img-fluid rounded" 
                                     alt="<?= Html::encode($item->product->name) ?>">
                            <?php else: ?>
                                <div class="bg-light d-flex justify-content-center align-items-center" style="height:80px;">
                                    <span class="text-muted">No Image</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4 col-8">
                            <h6 class="mb-1"><?= Html::encode($item->product->name) ?></h6>
                            <small class="text-muted">$<?= number_format($item->price, 2) ?> each</small>
                        </div>
                        <div class="col-md-2 col-4 mt-2 mt-md-0">
                            <input type="number" min="1" value="<?= Html::encode($item->quantity) ?>" 
                                   class="form-control form-control-sm text-center"
                                   onchange="updateCart(<?= $item->id ?>, this.value)">
                        </div>
                        <div class="col-md-2 col-4 mt-2 mt-md-0">
                            <strong>$<?= number_format($item->price * $item->quantity, 2) ?></strong>
                        </div>
                        <div class="col-md-2 col-4 text-end mt-2 mt-md-0">
                            <a href="<?= Url::to(['cart/remove', 'id' => $item->id]) ?>" 
                               class="btn btn-sm btn-outline-danger">
                                &times;
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <h4 class="mb-0">Total: $<?= number_format($total, 2) ?></h4>
            <div>
                <?= Html::a('Continue Shopping', ['product/index'], ['class' => 'btn btn-outline-secondary me-2']) ?>
                <?= Html::a('Checkout', ['checkout/index'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
$updateUrl = Url::to(['cart/update']);
$js = <<<JS
function updateCart(id, qty) {
    fetch('$updateUrl', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': yii.getCsrfToken()
        },
        body: JSON.stringify({id: id, quantity: qty})
    })
    .then(response => location.reload());
}
JS;
$this->registerJs($js);
?>
