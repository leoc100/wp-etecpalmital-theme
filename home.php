<?php
$slider_posts = [];
$query_slider_fixed = new WP_Query(['post_type' => ['post', 'link'], 'posts_per_page' => 7, 'tag' => 'slider-fixed']);
$slider_fixed_ids = [];
while($query_slider_fixed->have_posts()) {
  $query_slider_fixed->the_post();
  $slider_fixed_ids[] = get_the_ID();
  $slider_posts[] = [
    'url' => (get_post_type() == 'link') ? get_post_meta(get_the_ID(), 'url', true) : get_permalink(),
    'image' => get_the_post_thumbnail_url(),
    'title' => get_the_title(),
    'type' => get_post_type()
  ];
  wp_reset_postdata();
}
if(count($slider_posts) < 7) {
  $query_slider = new WP_Query(['post_type' => ['post', 'link'], 'post__not_in' => $slider_fixed_ids, 'posts_per_page' => (7 - count($slider_posts)) , 'tag' => 'slider']);
  while($query_slider->have_posts()) {
    $query_slider->the_post();
    $slider_fixed_ids[] = get_the_ID();
    $slider_posts[] = [
      'url' => (get_post_type() == 'link') ? get_post_meta(get_the_ID(), 'url', true) : get_permalink(),
      'image' => get_the_post_thumbnail_url(),
      'title' => get_the_title(),
      'type' => get_post_type()
    ];
    wp_reset_postdata();
  }
}
if(count($slider_posts) < 7) {
    $query_images = new WP_Query(['post_type' => 'attachment', 'post_mime_type' => 'image', 'post_status' => 'inherit', 'post__not_in' => $slider_fixed_ids, 'posts_per_page' => (7 - count($slider_posts)) , 'tag' => 'slider-fixed']);
    while($query_images->have_posts()) {
      $query_images->the_post();
      $slider_fixed_ids[] = get_the_ID();
      $slider_posts[] = [
        //'url' => wp_get_attachment_url(get_the_ID()),
        'image' => wp_get_attachment_url(get_the_ID()),
        //'title' => get_the_title(),
        'type' => get_post_type()
      ];
      wp_reset_postdata();
    }
}
if(count($slider_posts) < 7) {
    $query_images = new WP_Query(['post_type' => 'attachment', 'post_mime_type' => 'image', 'post_status' => 'inherit', 'post__not_in' => $slider_fixed_ids, 'posts_per_page' => (7 - count($slider_posts)) , 'tag' => 'slider']);
    while($query_images->have_posts()) {
      $query_images->the_post();
      $slider_fixed_ids[] = get_the_ID();
      $slider_posts[] = [
        //'url' => wp_get_attachment_url(get_the_ID()),
        'image' => wp_get_attachment_url(get_the_ID()),
        //'title' => get_the_title(),
        'type' => get_post_type()
      ];
      wp_reset_postdata();
    }
}

$links_uteis = $query_slider = new WP_Query(['post_type' => 'link', 'tag' => 'links-uteis']);
$etecnews_posts = new WP_Query(['post__not_in' => $slider_fixed_ids, 'posts_per_page' => 4, 'category_name' => 'etec-news']);
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>ETEC Palmital</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/footer.css" />
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/header.css" />
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/home.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    </head>
    <body>
        <?php get_header() ?>
        <div class="container">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
            <?php foreach($slider_posts as $id => $post): ?>
            <li data-target="#carouselExampleIndicators" data-slide-to="<?= $id ?>" <?= ($id == 0) ? 'class="active"' : "" ?>></li>
            <?php endforeach ?>
            </ol>
            <div class="carousel-inner">
            <?php foreach($slider_posts as $id => $post): ?>
            <div class="carousel-item <?= ($id == 0) ? 'active' : '' ?>">
                <?php if($post['type'] == 'attachment'): ?>
                <img class="d-block w-100" src="<?= $post['image'] ?>" alt="<?= $post['title'] ?>">
                <?php else: ?>
                <a <?= ($post['type'] == 'link') ? 'target="__blank"' : ''?> href="<?= $post['url'] ?>"><img class="d-block w-100" src="<?= $post['image'] ?>" alt="<?= $post['title'] ?>"></a>
                <?php endif; ?>
            </div>
            <?php endforeach ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
            </a>
        </div>
        </div>
        <div class="jumbotron text-light">
            <h1 class="text-center">Links Úteis</h1>
            <div class="container">
            <div class="row">
            <?php while($links_uteis->have_posts()): $links_uteis->the_post(); ?>
                <div class="col-sm text-center">
                    <a target="_blank" href="<?= get_post_meta(get_the_ID(), 'url', true) ?>">
                        <img src="<?= get_the_post_thumbnail_url() ?>" />
                    </a>
                </div>
            <?php wp_reset_postdata(); endwhile ?>
            </div>
                <!-- <div class="row">
                    <div class="col-sm text-center">
                        <img src="<?= get_template_directory_uri() ?>/img/moodle.png" />
                    </div>
                    <div class="col-sm text-center">
                        <a target="_blank" href="https://nsa.cps.sp.gov.br"><img src="<?= get_template_directory_uri() ?>/img/nsa.png" /></a>
                    </div>
                    <div class="col-sm text-center">
                        <a target="_blank" href="https://portal.office.com"><img src="<?= get_template_directory_uri() ?>/img/outlook.png" /></a>
                    </div>
                    <div class="col-sm text-center">
                        <a target="_blank" href="https://etec.onthehub.com/"><img src="<?= get_template_directory_uri() ?>/img/imagine.png" /></a>
                    </div>
                </div> -->
            </div>
        </div>
        <div class="container">
            <h1 class="text-center">Cursos Oferecidos</h1>
            <div class="row">
                <?php foreach(get_categories(['child_of' => get_category_by_slug('cursos')->term_id]) as $category): ?>
                <div class="col-sm text-center">
                    <h2><?= $category->name ?></h2>
                    <ul>
                    <?php foreach(get_posts(['category_name' => $category->name, 'orderby' => 'title', 'order' => 'ASC']) as $post): setup_postdata($post) ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php if(has_tag('inscricoes-abertas', $post->ID)): ?> <span class="link-destaque">  <a href="<?= get_permalink(get_page_by_path("inscricoes-abertas")) ?>"><i class="fa fa-caret-left" aria-hidden="true"></i> Inscições Abertas</a></span><?php endif ?></li>
                    <?php wp_reset_postdata(); ?>
                    <?php endforeach ?>
                    </ul>
                </div>
                <?php endforeach ?>
            
                <!-- <div class="col-sm text-center">
                    <h2>Ensino Técnico Integrado ao Médio (Integral)</h2>
                    <ul>
                        <li><a href="/etim-administracao">Administração</a></li>
                        <li><a href="/etim-informatica-para-internet">Informática para Internet</a></li>
                    </ul>
                </div>
                <div class="col-sm text-center">
                    <h2>Ensino Técnico (Noturno)</h2>
                    <ul>
                        <li><a href="/contabilidade">Contabilidade<a></li>
                        <li><a href="/desenvolvimento-de-sistemas">Desenvolvimento de Sistemas</a></li>
                        <li><a href="/enfermagem">Enfermagem</a></li>
                        <li><a href="/informatica-para-internet">Informática para Internet</a></li>
                        <li><a href="/recursos-humanos">Recursos Humanos</a></li>
                        <li><a href="/servicos-juridicos">Serviços Jurídicos</a></li>
                    </ul>
                </div> -->
            </div>
        </div>
        <div class="text-light bg-dark">
            <h1 class="text-center">ETEC News</h1>
            <div class="container">
                <div class="row">
                <?php while($etecnews_posts->have_posts()): $etecnews_posts->the_post(); ?>
                    <div class="col-sm">
                        <h2 class="text-center"><?= get_the_title() ?></h2>
                        <?= get_the_excerpt() ?>
                    </div>
                <?php wp_reset_postdata(); endwhile ?>
                </div>
            </div>
        </div>

        <?= get_footer() ?>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html> 