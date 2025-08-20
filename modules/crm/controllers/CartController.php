<?php

namespace crm\controllers;

use Yii;
use crm\models\Cart;
use crm\models\searches\CartSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

use crm\models\CartItems;
use crm\models\Product;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends DashboardController
{
    public $permissions = [
        'crm-cart-list'=>'View Cart List',
        'crm-cart-create'=>'Add Cart',
        'crm-cart-update'=>'Edit Cart',
        'crm-cart-delete'=>'Delete Cart',
        'crm-cart-restore'=>'Restore Cart',
        ];
 public function actionIndex()
{
    $searchModel = new CartSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);

    // Fetch the active cart for the logged-in user
    $cart = Cart::find()
        ->where(['user_id' => Yii::$app->user->id, 'status' => 'active', 'is_deleted' => 0])
        ->one();

    $cartItems = [];
    $total = 0;

    if ($cart) {
        $cartItems = CartItems::find()
            ->where(['cart_id' => $cart->id, 'is_deleted' => 0])
            ->with('product')
            ->all();

        $total = (float) CartItems::find()
            ->where(['cart_id' => $cart->id, 'is_deleted' => 0])
            ->sum(new \yii\db\Expression('quantity * price'));
    }

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'cartItems'   => $cartItems,
        'total'       => $total,
    ]);
}

    public function actionCreate()
    {
        Yii::$app->user->can('crm-cart-create');
        $model = new Cart();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Cart created successfully');
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

    // Find or create cart (you can improve this later)
    $cart = Cart::findOne(['user_id' => Yii::$app->user->id]);
    if (!$cart) {
        $cart = new Cart();
        $cart->user_id = Yii::$app->user->id;
        $cart->save();
        if (!$cart->save()) {
        Yii::error('Failed to create cart: ' . json_encode($cart->errors), 'debug');
    }
    }

    // Add item or update quantity
    $item = CartItems::findOne(['cart_id' => $cart->id, 'product_id' => $product_id]);
    if ($item) {
        $item->quantity += 1;
    } else {
        $item = new CartItems([
            'cart_id' => $cart->id,
            'product_id' => $product_id,
            'quantity' => 1,
        ]);
    }

    $item->save();

    Yii::$app->session->setFlash('success', 'Product added to cart.');
    return $this->redirect(['cart/index']);
}
    
    public function actionUpdate($id)
    {
        Yii::$app->user->can('crm-cart-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Cart updated successfully');
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
            Yii::$app->user->can('crm-cart-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'Cart has been restored');
        } else {
            Yii::$app->user->can('crm-cart-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'Cart has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Cart::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
