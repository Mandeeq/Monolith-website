<?php

namespace crm\controllers;

use Yii;
use crm\models\Product;
use crm\models\searches\ProductSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;
use crm\models\Cart;
use crm\models\CartItems;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends DashboardController
{
    public $permissions = [
        'crm-product-list'=>'View Product List',
        'crm-product-create'=>'Add Product',
        'crm-product-update'=>'Edit Product',
        'crm-product-delete'=>'Delete Product',
        'crm-product-restore'=>'Restore Product',
        ];
    public function actionIndex()
    {
        Yii::$app->user->can('crm-product-list');
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        Yii::$app->user->can('crm-product-create');
        $model = new Product();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Product created successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

public function actionAdd($product_id)
{
    $product = Product::findOne($product_id);
    if (!$product) {
        throw new \yii\web\NotFoundHttpException('Product not found.');
    }

    $userId = Yii::$app->user->id;

    // 1. Find or create active cart for this user
    $cart = Cart::find()
        ->where(['user_id' => $userId, 'status' => 'active', 'is_deleted' => 0])
        ->one();

    if (!$cart) {
        $cart = new Cart();
        $cart->user_id = $userId;
        $cart->status = 'active';
        $cart->created_at = time();
        $cart->updated_at = time();
        $cart->quantity = 0;
        $cart->total_price = 0.00;

        if (!$cart->save()) {
            Yii::error('Failed to create cart: ' . json_encode($cart->errors), __METHOD__);
            Yii::$app->session->setFlash('error', 'Unable to create cart.');
            return $this->redirect(['product/index']);
        }
    }

    // 2. Find cart item or create a new one
    $item = CartItems::find()
        ->where(['cart_id' => $cart->id, 'product_id' => $product_id, 'is_deleted' => 0])
        ->one();

    if ($item) {
        $item->quantity += 1; // Increment quantity if already in cart
        $item->updated_at = time();
    } else {
        $item = new CartItems([
            'cart_id' => $cart->id,
            'product_id' => $product_id,
            'quantity' => 1,
            'price' => $product->price,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    if (!$item->save()) {
        Yii::error('Failed to add item to cart: ' . json_encode($item->errors), __METHOD__);
        Yii::$app->session->setFlash('error', 'Unable to add product to cart.');
        return $this->redirect(['product/index']);
    }

    // 3. Update cart totals
    $cart->quantity = (int) CartItems::find()->where(['cart_id' => $cart->id, 'is_deleted' => 0])->sum('quantity');
    $cart->total_price = (float) CartItems::find()
        ->where(['cart_id' => $cart->id, 'is_deleted' => 0])
        ->sum(new \yii\db\Expression('quantity * price'));
    $cart->updated_at = time();
    $cart->save(false);

    // 4. Success message
    Yii::$app->session->setFlash('success', "{$product->name} has been added to your cart.");

    return $this->redirect(['cart/index']);
}

    public function actionUpdate($id)
    {
        Yii::$app->user->can('crm-product-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Product updated successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionTrash($id)
    {
        $model = $this->findModel($id);
        if ($model->is_deleted) {
            Yii::$app->user->can('crm-product-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'Product has been restored');
        } else {
            Yii::$app->user->can('crm-product-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'Product has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
