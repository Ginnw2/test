<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <title>Slick slider</title>
</head>
<body>
<div class="slider multiple-items">
    <div>1</div>
    <div>2</div>
    <div>3</div>
    <div>4</div>
    <div>5</div>

</div>
<?
/**
 * Created by PhpStorm.
 * User: ginn
 * Date: 20/06/2019
 * Time: 13:31
 */

    $ch = curl_init("https://b2b.i-t-p.pro/api");
    //Аутентификация
    $dataAuth = array("request" => array(
                        "method" => "login",
                        "module" => "system"
                        ),
                  "data" => array(
                        "login" => "ruscomp",
                        "passwd" => "456852"
                        )
                    );
    $dataAuthString = json_encode($dataAuth);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataAuthString);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Length: ' . strlen($dataAuthString)
    ));
    $result = curl_exec($ch);
    curl_close ($ch);
    $resAuth = json_decode($result);
    if (($resAuth) && ($resAuth->success) && ($resAuth->success == 1))
        echo "Auth success. session_id=" . $resAuth->data->session_id;
    else {
        echo "Auth Error\n";
        print_r($resAuth);
        die();
    }
    //Запоминаем сессию
    $session = $resAuth->data->session_id;

    //Получение дерева категорий
    $ch = curl_init("https://b2b.i-t-p.pro/download/catalog/json/catalog_tree.json");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Cookie: session_id=' . $session )
    );
    $result = curl_exec($ch);
    curl_close ($ch);
    $resCatalogTree = json_decode($result);
    echo "<pre>"; print_r($resCatalogTree['0']['29']);
    //Список товаров получаем аналогичным образом
    //Получение всех товаров в наличии их цены
    $ch = curl_init("https://b2b.i-t-p.pro/api");
    $dataAuth = array("request" => array(
                        "method" => "get_active_products",
                        "model"  => "client_api",
                        "module" => "platform"
                        ),
                      "session_id" => $session
                    );
    $dataAuthString = json_encode($dataAuth);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataAuthString);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Length: ' . strlen($dataAuthString)
    ));
    $result = curl_exec($ch);
    curl_close ($ch);
    $resProducts = json_decode($result);
    //echo "<pre>"; print_r($resProducts);

?>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
    $('.multiple-items').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
    function getSliderSettings(){
        return {
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        }
    }

    $('.multiple-items').on('afterChange', function(event, slick, currentSlide) {
        console.log(slick['slideCount']);
        if (currentSlide == 0 && slick['slideCount']==5) {
            var id = 1;

            var form_data = new FormData();
            form_data.append('id', id);

            $.ajax({
                url: 'ajax.php',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'ajax',
                success: function (php_script_response) {
                    $(".multiple-items").html(php_script_response);
                    $('.multiple-items').slick('unslick');
                    $('.multiple-items').slick(getSliderSettings());
                }
            });
            event.preventDefault();  // Полная остановка происходящего
        }
    });
</script>
</body>
</html>