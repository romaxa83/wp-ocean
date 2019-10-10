<?php

use backend\modules\filter\widgets\filter\FilterWidget;
use backend\modules\request\widgets\request\RequestWidget;
?>
<div class="search-section pt-0">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php echo (isset(Yii::$app->view->params['breadcrumbs'])) ? Yii::$app->view->params['breadcrumbs'] : FALSE; ?>
            </div>
        </div>
    </div>

    <?php echo FilterWidget::widget(['alias' => $alias, 'data' => Yii::$app->request->get()]); ?>
</div>
<div class="loader loader-plane">
    <div class="loader-plane__caption">
        <span class="loader-plane__title"> Для вас мы найдем самые лучшие туры </span>
    </div>
    <div class="loader-plane__wrapper">
        <svg class="loader-plane__cloud-left" width="42" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 427.1 292.12">
            <path d="M428.37,279.3c-1.15,45.14-38.8,80.82-84,80.82H81.79C37.68,360.12.92,324,1.3,279.93A79.51,79.51,0,0,1,73,201.53c-.09-1.34-.21-2.67-.21-4a63.59,63.59,0,0,1,91-57.51,102.86,102.86,0,0,1,199.15,50.29A90.16,90.16,0,0,1,428.4,277C428.4,277.75,428.39,278.52,428.37,279.3Z" transform="translate(-1.3 -68)"/>
        </svg>

        <svg class="loader-plane__cloud-centre" width="65" height="45" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 428.4 292.93">
            <path d="M277.2,119.33c5.6-.4,10.4-4.8,10.4-10.4V78.13a10.4,10.4,0,0,0-20.8,0v30.8A10.58,10.58,0,0,0,277.2,119.33Z" transform="translate(0 -67.73)"/>
            <path d="M362,148.13l22-22a10.18,10.18,0,0,0-14.4-14.4l-22,22a10.18,10.18,0,1,0,14.4,14.4Z" transform="translate(0 -67.73)"/>
            <path d="M418,208.54H387.2a10.4,10.4,0,1,0,0,20.79H418a10.59,10.59,0,0,0,10.4-10.4A10.32,10.32,0,0,0,418,208.54Z" transform="translate(0 -67.73)"/>
            <path d="M362,289.33a10.18,10.18,0,1,0-14.4,14.4l22,22a10.18,10.18,0,0,0,14.4-14.4Z" transform="translate(0 -67.73)"/>
            <path d="M192.4,148.13a10.18,10.18,0,1,0,14.4-14.39l-22-22a10.18,10.18,0,0,0-14.4,14.4Z" transform="translate(0 -67.73)"/>
            <path d="M254.4,232.54a65.08,65.08,0,0,0-26.4,5.6,61,61,0,0,0-21.6,16,10.2,10.2,0,1,1-15.2-13.6,82.9,82.9,0,0,1,28.8-21.2c2-.8,4.4-2,6.4-2.8a87.67,87.67,0,0,0-27.2-30.8,85.92,85.92,0,0,0-49.6-15.6A86.36,86.36,0,0,0,64,243.74a9.19,9.19,0,0,1-4.8,7.2,9.18,9.18,0,0,1-5.6,1.6,52.53,52.53,0,0,0-38,16,53.83,53.83,0,0,0-15.6,38,52.53,52.53,0,0,0,16,38,54.17,54.17,0,0,0,38,16H255.2c17.2,1.2,33.2-6,44.8-18a64.4,64.4,0,0,0-45.6-110Z" transform="translate(0 -67.73)"/>
            <path d="M352.8,218.93a74.6,74.6,0,0,0-22.4-53.6,76.26,76.26,0,0,0-53.6-22.4,77.86,77.86,0,0,0-39.2,10.81,80.47,80.47,0,0,0-22,20,100.47,100.47,0,0,1,14.8,14.39,105.71,105.71,0,0,1,16,24.8,49.64,49.64,0,0,1,7.6-.39,84.62,84.62,0,0,1,60,24.8,119.09,119.09,0,0,1,9.2,10.8,73.05,73.05,0,0,1,10.4,20,53.12,53.12,0,0,0,13.2-19.6A75.35,75.35,0,0,0,352.8,218.93Z" transform="translate(0 -67.73)"/>
        </svg>

        <svg class="loader-plane__cloud-right" xmlns="http://www.w3.org/2000/svg" width="37" height="27"  viewBox="0 0 427.1 292.12">
            <path  d="M1.33,279.3c1.15,45.14,38.8,80.82,84,80.82H347.91c44.11,0,80.87-36.08,80.49-80.19a79.51,79.51,0,0,0-71.66-78.4c.09-1.34.21-2.67.21-4A63.59,63.59,0,0,0,266,140,102.86,102.86,0,0,0,66.84,190.28,90.16,90.16,0,0,0,1.3,277C1.3,277.75,1.31,278.52,1.33,279.3Z" transform="translate(-1.3 -68)"/>
        </svg>

        <svg  class="loader-plane__cloud-mountains" xmlns="http://www.w3.org/2000/svg" width="72" height="60" viewBox="0 0 45.91 36.82">
            <path d="M45.8,32.17,34.26,6a2.43,2.43,0,0,0-4.45,0L23.9,19.41,19,8.36a2.87,2.87,0,0,0-5.25,0L.12,39.29a1.48,1.48,0,0,0,1.36,2.07H31.31a1.47,1.47,0,0,0,1.24-.67,1.46,1.46,0,0,0,.12-1.4L30.3,33.92H44.66a1.27,1.27,0,0,0,1.05-.56A1.26,1.26,0,0,0,45.8,32.17Zm-23.67-8.7a.71.71,0,0,1-.9,0c-.71-.65-2.34-2.56-2.86-2.56-.76,0-1.19,1.17-2,1.17-.49,0-1.56-1.64-1.56-1.64a.75.75,0,0,0-1-.09l-1.33,1a.74.74,0,0,1-.9,0,.76.76,0,0,1-.22-.88l4.25-9.64a.9.9,0,0,1,.74-.63.93.93,0,0,1,.74.63l5.21,11.78A.74.74,0,0,1,22.13,23.47Zm14.76-4.69a.6.6,0,0,1-.77,0c-.6-.55-2-2.16-2.42-2.16-.64,0-1,1-1.67,1-.41,0-1.31-1.38-1.31-1.38a.64.64,0,0,0-.83-.08L28.77,17A.63.63,0,0,1,28,17a.62.62,0,0,1-.18-.74l3.59-8.16A.76.76,0,0,1,32,7.54a.77.77,0,0,1,.63.53l4.41,10A.63.63,0,0,1,36.89,18.78Z" transform="translate(0 -4.55)"/>
        </svg>

        <svg class="loader-plane__cloud-palms" xmlns="http://www.w3.org/2000/svg" width="106" height="82" viewBox="0 0 414.06 319.65">
            <path  d="M413,230.68c-.84-1-20.77-23.06-43.32-23.84-10-.33-17.2,1.34-22,3.14-2.61-4.79-8.6-12.56-21.92-19.32-6.09-3.09-13.5-4.66-22-4.66a92,92,0,0,0-27.4,4.56,4.32,4.32,0,0,0-.42,8c3,1.39,17.28,7.92,25.89,8.82-22.4,3.62-41.58,22.93-42.47,23.83a4.31,4.31,0,0,0-.9,4.7,4.24,4.24,0,0,0,3.9,2.64h.32c4.24-.06,26.69-.63,34-5.58l.68-.47a4.28,4.28,0,0,0,3.48,1.77h12.68a4.4,4.4,0,0,0,2.24-.63l.42.12c.16,0,.74.19,1.65.36-19.28,14.32-32.83,38.72-41.64,59.93-13.74-43.74-43.45-118.61-94.3-156.37,1.72-.32,2.82-.59,3.13-.67a7.75,7.75,0,0,0,.78-.24A8.15,8.15,0,0,0,190,138H213.9a8.13,8.13,0,0,0,6.58-3.35c.42.3.85.6,1.28.88,13.78,9.36,56.16,10.44,64.16,10.54l.62,0a8,8,0,0,0,7.36-5,8.12,8.12,0,0,0-1.7-8.87c-1.68-1.7-37.9-38.17-80.19-45,16.25-1.7,43.29-14,48.88-16.66a8.1,8.1,0,0,0,4.69-7.76,8.19,8.19,0,0,0-5.49-7.32c-2.54-.88-25.67-8.61-51.71-8.61-16.08,0-30.07,2.95-41.57,8.79-25.14,12.77-36.46,27.44-41.39,36.48-9.1-3.4-22.78-6.56-41.58-5.93-42.58,1.48-80.2,43.22-81.79,45a8.13,8.13,0,0,0-1.22,9,8.22,8.22,0,0,0,7.85,4.55c7.38-.49,44.83-3.34,56.74-12.34a1.75,1.75,0,0,0,.35-.23,8.25,8.25,0,0,0,4.92,2.26l.34.07,19.31-1a148.43,148.43,0,0,0-12.13,13C47.43,183.35,54.27,246.33,54.58,249a8.14,8.14,0,0,0,14.48,4.08c3.16-4,30.93-39.74,32.34-56.81,0-.51.09-1,.13-1.56h.4a8.08,8.08,0,0,0,6.33-3l15.07-18.64a8.14,8.14,0,0,0,1.72-4,6.9,6.9,0,0,0,.63-.42A87.69,87.69,0,0,0,148,142.69c18.61,21.75,71.19,90.1,77.57,174.76-53.43,3-92.56,12.62-92.56,24.05,0,13.81,57.08,25,127.5,25S388,355.31,388,341.5c0-11.39-38.82-21-91.93-24,6.76-39.3,30.64-70.24,39.61-80.73A46.58,46.58,0,0,0,347.5,250.5a2.7,2.7,0,0,0,.33.22,4.38,4.38,0,0,0,.91,2.14l8,9.87a4.25,4.25,0,0,0,3.34,1.6h.22c0,.28,0,.55.07.82.74,9,15.45,28,17.12,30.09a4.32,4.32,0,0,0,7.68-2.16c.16-1.42,3.78-34.78-12.52-54.32a77.26,77.26,0,0,0-6.43-6.86l10.23.52.18,0a4.29,4.29,0,0,0,2.61-1.2,1,1,0,0,0,.18.13c6.31,4.76,26.14,6.28,30,6.53a4.32,4.32,0,0,0,3.52-7.16Z" transform="translate(0 -46.85)"/>
        </svg>

        <div class="loader-plane__scene">
            <svg class="loader-plane__item" width="43" height="37" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 382.28 428.4">
                <path d="M183.73,404.39a11.47,11.47,0,0,0,9.68-6.11l21.66-41h15.34a10.15,10.15,0,0,0,10.13-10.12v-9.87a10.15,10.15,0,0,0-9.6-10.1l3.5-6.62h16.63a10.15,10.15,0,0,0,10.12-10.13v-9.87a10.14,10.14,0,0,0-10.12-10.12h-.74l20.5-38.87c91.23-1.82,157.57-9.78,157.57-37.33s-66.34-35.51-157.57-37.33L250.33,138h.74a10.14,10.14,0,0,0,10.12-10.12V118a10.15,10.15,0,0,0-10.12-10.13H234.44l-3.5-6.62a10.15,10.15,0,0,0,9.6-10.1V81.29a10.15,10.15,0,0,0-10.13-10.12H215.07l-21.66-41A11.47,11.47,0,0,0,183.73,24l-22.28-.94A10.21,10.21,0,0,0,151.19,36L178,129.14a87.42,87.42,0,0,1,3.41,24.16v23.57c-42,1.1-78,4.12-106.3,8.51l-45.47-53.2A23.11,23.11,0,0,0,8,124.79l-1.2.23A8.38,8.38,0,0,0,.43,135.88l20.7,62.8.9-.09c-11.11,4.75-17,10-17,15.61s5.91,10.86,17,15.61l-.9-.09L.43,292.52a8.38,8.38,0,0,0,6.39,10.86l1.2.23a23.11,23.11,0,0,0,21.62-7.39L75.11,243c28.29,4.39,64.27,7.41,106.3,8.51V275.1A87.42,87.42,0,0,1,178,299.26l-26.81,93.13a10.21,10.21,0,0,0,10.26,12.94Z" transform="translate(0 -23.06)"/>
            </svg>

            <svg class="loader-plane__path" width="1969" height="107">
                <defs>
                    <mask id="graph">
                    <path id="path" d="M1,106C70.276,38.076,249.75-12.191,389,46S581.723,12.512,752,22s257.31,108.079,410,41,239.26-78.164,395-40,232.59,79.348,421,31" fill="none" stroke="white" stroke-width="4"/>
                    </mask>
                    <linearGradient id="myGradient">
                    <stop offset="5%"  stop-color="transparent"/>
                    <stop offset="95%" stop-color="#423067"/>
                    </linearGradient>
                </defs>

                <g mask="url(#graph)">
                    <path id="way" d="M1,106C70.276,38.076,249.75-12.191,389,46S581.723,12.512,752,22s257.31,108.079,410,41,239.26-78.164,395-40,232.59,79.348,421,31"/>
                    <rect id="rect" x="0" y="0" width="250" height="500" fill="url(#myGradient)"/>
                </g>
            </svg>    
        </div>  
    </div>    
</div>
<div id="search-result"></div>
<div class="request-widget d-none">
    <?php echo RequestWidget::widget(); ?>
</div>
<?php if (isset($seo) && count($seo) > 0 && $seo['status'] == TRUE): ?>
    <section class="section section-seo grey-bg">
        <div class="container invisible">
            <div class="seo-wrapper" id="collapseExample">
                <h1><?php echo $seo['seo']['h1']; ?></h1>
                <?php echo $seo['seo']['seo_text']; ?>
            </div>
        </div>
    </section>
<?php endif; ?>