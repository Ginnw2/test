<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <title>Slick slider</title>
</head>
<body>
<div class="slider multiple-items">
    <div>1</div>
    <div>2</div>
    <div>3</div>
    <div>4</div>

</div>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
    $('.multiple-items').slick({
        infinite: true,
        dots: true,
        slidesToShow: 3,
        slidesToScroll: 1
    });
    $('.multiple-items').on('afterChange', function(event, slick, currentSlide) {
        if (currentSlide == 4) {
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

                }
            });
            event.preventDefault();  // Полная остановка происходящего
        }
    });
</script>
</body>
</html>