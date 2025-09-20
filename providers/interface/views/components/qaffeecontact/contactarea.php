<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var qaffee\models\ContactForm $model */
$model->subject = 'Customer Inquiry'; // Default subject
$model->name = 'test'; // Default name
$model->email = 'theurij113@gmail.com';
// $model->subject = 'Inquiry about services'; // Default subject  
$model->message = 'Hello, I would like to know more about your services.'; // Default message
?>

<section class="contact-section section_padding">
    <div class="container">
        <div class="d-none d-sm-block mb-5 pb-4">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15923.644246183776!2d39.658742!3d-4.0645728!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1840130fe45c5bf1%3A0x662b37266b834793!2sNyerere%20Rd%2C%20Mombasa!5e0!3m2!1sen!2ske!4v1692432000000!5m2!1sen!2ske" 
                width="100%" 
                height="480" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="contact-title">Get in Touch</h2>
                <p class="contact-description">We'd love to hear from you! Fill out the form below, and we'll get back to you as soon as possible.</p>

                <?php if (Yii::$app->session->hasFlash('success')): ?>
                    <div class="alert alert-success">
                        <?= Yii::$app->session->getFlash('success') ?>
                    </div>
                <?php elseif (Yii::$app->session->hasFlash('error')): ?>
                    <div class="alert alert-danger">
                        <?= Yii::$app->session->getFlash('error') ?>
                    </div>
                <?php endif; ?>

                <?php $form = ActiveForm::begin([
                    'id' => 'contact-form',
                    'options' => ['class' => 'contact-form'],
                ]); ?>

                <?= $form->field($model, 'name')->textInput(['placeholder' => 'Enter your name']) ?>
                <?= $form->field($model, 'email')->textInput(['placeholder' => 'Enter your email']) ?>
                <?= $form->field($model, 'subject')->textInput(['placeholder' => 'Enter subject']) ?>
                <?= $form->field($model, 'message')->textarea(['rows' => 6, 'placeholder' => 'Enter your message']) ?>

                <div class="form-group text-center">
                    <?= Html::submitButton('Send Message', ['class' => 'btn btn-primary btn_4']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
            <div class="col-lg-4">
                <div class="media contact-info">
                    <span class="contact-info__icon"><i class="ti-home"></i></span>
                    <div class="media-body">
                        <h3>Mombasa, Kizingo.</h3>
                        <p>Ralli House, Mombasa</p>
                    </div>
                </div>
                <div class="media contact-info">
                    <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                    <div class="media-body">
                        <h3>+254758222222</h3>
                        <p>Mon to Fri 7am to 11pm</p>
                    </div>
                </div>
                <div class="media contact-info">
                    <span class="contact-info__icon"><i class="ti-email"></i></span>
                    <div class="media-body">
                        <h3>support@qaffee.com</h3>
                        <p>Send us your query anytime!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.contact-section {
    padding: 50px 0;
}
.contact-title {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 20px;
    text-align: center;
}
.contact-description {
    font-size: 16px;
    color: #666;
    text-align: center;
    margin-bottom: 30px;
}
.contact-form .form-group {
    margin-bottom: 20px;
}
.contact-form input,
.contact-form textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}
.contact-form textarea {
    resize: vertical;
}
.btn_4 {
    padding: 12px 30px;
    font-size: 16px;
    border-radius: 5px;
}
.contact-info {
    margin-bottom: 20px;
    display: flex;
    align-items: center;
}
.contact-info__icon {
    font-size: 24px;
    margin-right: 15px;
    color: #e74c3c;
}
.contact-info .media-body h3 {
    font-size: 18px;
    margin-bottom: 5px;
}
.contact-info .media-body p {
    font-size: 14px;
    color: #666;
}
@media (max-width: 767px) {
    .contact-title {
        font-size: 24px;
    }
    .contact-description {
        font-size: 14px;
    }
    .contact-info__icon {
        font-size: 20px;
    }
}
</style>