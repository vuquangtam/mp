<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\HomeAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

HomeAsset::register($this);
$urlPrefix = (isset(Yii::$app->params['urlPrefix'])? $urlPrefix = Yii::$app->params['urlPrefix'] : '.');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" >
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <style type="text/css">
    body {
     background: url('<?= $urlPrefix ?>/img/home/home-<?= Yii::$app->params['site']['img'] ?>.jpg') no-repeat center 30px;
    }
    </style>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
        <div class="wrap">
        <?php
              NavBar::begin([
                'brandLabel' =>  Yii::$app->params['site']['title'].'&nbsp;<span class="badge">preview</span>', //
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => Yii::$app->params['site']['navbar'].' navbar-fixed-top',
                ],
            ]);
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => Yii::t('frontend','Features'), 'url' => ['/features']];
                $menuItems[] = ['label' => Yii::t('frontend','Signup'), 'url' => ['/site/signup']];
                $menuItems[] = ['label' => Yii::t('frontend','Login'), 'url' => ['/site/login']];
            } else {
	            $menuItems = [
                  ['label' => Yii::t('frontend','Schedule'), 'url' => ['/meeting/create']],
                  [
                    'label' => Yii::$app->params['site']['mtg'],
                    'url' => ['/meeting'],
                    'options'=>['class'=>'menuHide'],
                  ],
                  [
                    'label' => Yii::t('frontend','Help'),
                    'url'=>['/ticket'], //Url::to('https://meetingplanner.freshdesk.com/support/home')
                  ],
	            ];
            }
      			if (Yii::$app->user->isGuest) {
              $menuItems[]=['label' => Yii::t('frontend','Help'),
                'items' => [
                  ['label' => Yii::t('frontend','Questions?'), 'url' => ['/ticket']],
                  ['label' => Yii::t('frontend','Blog'), 'url' => 'https://blog.meetingplanner.io'],
                  ['label' => Yii::t('frontend','About'), 'url' => ['/about']],
                ],
              ];
              echo Nav::widget([
                  'options' => ['class' => 'navbar-nav navbar-right'],
                  'items' => $menuItems,
              ]);
            } else {
      				$menuItems[] = [
                          'label' => 'Account',
      				            'items' => [
                            [
                              'label' => Yii::t('frontend','Places'),
                               'url' => ['/place/yours'],
                             ],
    				                 [
    				                    'label' => Yii::t('frontend','Friends'),
    				                    'url' => ['/friend'],
                                'options'=>['class'=>'menuHide'],
    				                ],
                            [
                               'label' => Yii::t('frontend','Reminders'),
                               'url' => ['/reminder'],
                               //'options'=>['class'=>'menuHide'],
                           ],[
                                'label' => Yii::t('frontend','Contact details'),
                                'url' => ['/user-contact'],
                                'options'=>['class'=>'menuHide'],
                            ],
       				                 [
                                  'label' => Yii::t('frontend','Profile details'),
                                  'url' => ['/user-profile'],
                                  //'options'=>['class'=>'menuHide'],
                              ],
                              [
                               'label' => Yii::t('frontend','Settings'),
                               'url' => ['/user-setting'],
                               //'options'=>['class'=>'menuHide'],
                             ],
      				                 [
      				                    'label' => Yii::t('frontend','Logout').' (' . \common\components\MiscHelpers::getDisplayName(Yii::$app->user->id) . ')',
      				                    'url' => ['/site/logout'],
      				                    'linkOptions' => ['data-method' => 'post']
      				                ],
      				            ],
      				        ];
                      echo Nav::widget([
                          'options' => ['class' => 'navbar-nav navbar-right'],
                          'items' => $menuItems,
                      ]);
      			}
            echo \kmergen\LanguageSwitcher::widget([
                   'parentTemplate' => '<nav class="navbar-nav nav no-collapse">
                    <li class="dropdown">{activeItem}
                        <ul class="dropdown-menu">{items}</ul>
                     </li>
                 </nav>',
                 'activeItemTemplate' => '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="flag flag-{language}"></i> <span class="caret"></span></a>',
                 'itemTemplate' => '<li><a href="{url}"><i class="flag flag-{language}"></i> {label}</a></li>'
            ]);
            NavBar::end();
        ?>

        <div class="container_home">
        <?php
        echo Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
          <p class="pull-left">
            <?php
              echo Html::a('&copy; Lookahead '.date('Y'),'http://lookahead.io',['class'=>'itemHide']);
              echo Html::tag('span',' . ',['class'=>'itemHide']);
              echo Html::a(Yii::t('frontend','privacy'),Url::to(['/site/privacy']));
              echo Html::tag('span',' . '.Html::a(Yii::t('frontend','terms'),Url::to(['/site/tos'])));
            ?>
        <p class="pull-right">
        <?= Html::a('@meetingio','https://twitter.com/intent/user?screen_name=meetingio') ?>
        <?= Html::tag('span',' . '.Html::a(Yii::t('frontend','blog'),Url::to('https://blog.meetingplanner.io'))); ?>
        <?php
        if (!Yii::$app->user->isGuest) {
          echo Html::tag('span',' . '.Html::a(Yii::t('frontend','features'),Url::to(['/features'])),['class'=>'itemHide']);
          echo Html::tag('span',' . '.Html::a(Yii::t('frontend','about'),Url::to(['/about'])),['class'=>'itemHide']);
        }
         ?>
        </p>
        </div>
    </footer>
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', '<?php echo Yii::$app->params['site']['ga']; ?>', 'auto');
  ga('send', 'pageview');
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
