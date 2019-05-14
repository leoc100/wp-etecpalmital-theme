<?php
$id_main_category = get_category_by_slug('documentos')->term_id;
$query_categories = get_categories(['child_of' => $id_main_category, 'hide_empty' => 0]);
$categories = [];
foreach($query_categories as $c)
    $categories[$c->term_id] = $c;
$menu_doc = [];
foreach($categories as $k => $c) {
    if($c->parent == $id_main_category) {
        if(!array_key_exists($c->name, $menu_doc)){
            $menu_doc[$c->name] = [];
        }
    } else {
        $_posts = get_posts(['post_type' => ['attachment', 'page'], 'post_status' => ['inherit', 'publish'], 'cat' => $c->term_id]);
        if(count($_posts) == 1) {
            if($_posts[0]->post_type == 'page') {
                if($_posts[0]->post_status == 'publish') {
                    $menu_doc[$categories[$c->parent]->name][$_posts[0]->post_title] = ['type' => 'page', 'url' => get_permalink($_posts[0]->ID)];
                }
            } else {
                $menu_doc[$categories[$c->parent]->name][$_posts[0]->post_title] = ['type' => 'attachment', 'url' => wp_get_attachment_url($_posts[0]->ID)];
            }
        } else if(count($_posts) > 0) {
            $menu_doc[$categories[$c->parent]->name][$c->name] = ['type' => 'category', 'url' => get_category_link($c->term_id)];
        }
    }
}
?>

    <nav class="navbar navbar-expand-lg navbar-light d-md-block">
        <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-danger" href="<?= get_home_url() ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="<?= get_permalink(get_page_by_path("biblioteca")) ?>">Biblioteca</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="<?= get_permalink(get_page_by_path("equipe-escolar")) ?>">Equipe Escolar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="<?= get_permalink(get_page_by_path("contatos")) ?>">Contatos</a>
                </li>
            </ul>
        </div>
    </nav>
    <img class="mx-auto d-none d-lg-block d-xl-block" src="<?= get_template_directory_uri() ?>/img/header-1000.png" />
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="<?= get_home_url() ?>" aria-expanded="false"><img class="d-lg-none" src="<?= get_template_directory_uri() ?>/img/logo-etec.png" height="48px" /></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown-cursos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cursos</a>
            <div class="dropdown-menu" aria-labelledby="dropdown-cursos">
                <?php foreach(get_categories(['child_of' => get_category_by_slug('cursos')->term_id]) as $category): ?>
                <h6 class="dropdown-header"><?= $category->name ?></h6>
                    <?php foreach(get_posts(['category_name' => $category->name, 'orderby' => 'title', 'order' => 'ASC']) as $post): setup_postdata($post) ?>
                    <a class="dropdown-item" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <?php wp_reset_postdata(); ?>
                    <?php endforeach ?>
                <?php endforeach ?>
            </div>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown-noticias" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Notícias</a>
            <div class="dropdown-menu" aria-labelledby="dropdown-noticias">
                <a class="dropdown-item" href="<?= get_category_link(get_category_by_slug('etec-news')->term_id) ?>">ETEC News</a>
                <a class="dropdown-item" href="<?= get_category_link(get_category_by_slug('eventos')->term_id) ?>">Eventos</a>
                <a class="dropdown-item" href="<?= get_category_link(get_category_by_slug('palestras')->term_id) ?>">Palestras</a>
                <a class="dropdown-item" href="<?= get_category_link(get_category_by_slug('visitas-tecnicas')->term_id) ?>">Visitas Técnicas</a>
                <a class="dropdown-item" href="<?= get_category_link(get_category_by_slug('noticias')->term_id) ?>">Todas</a>
            </div>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="<?= get_permalink(get_page_by_path("projetos")) ?>">Projetos</a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown-mercado" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mercado de Trabalho</a>
            <div class="dropdown-menu" aria-labelledby="dropdown-mercado">
                <a class="dropdown-item" href="<?= get_permalink(get_page_by_path("cursos-online")) ?>">Cursos On-Line</a>
                <a class="dropdown-item" target="__blank" href="http://auth.guiadoestudante.abril.com.br/?u=http%3A%2F%2Ftestevocacional.guiadoestudante.abril.com.br%2F">Teste Vocacional</a>
                <a class="dropdown-item" href="<?= get_permalink(get_page_by_path("vagas-de-estagio")) ?>">Vagas de Estágio</a>
            </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown-documentos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Documentos</a>
                <div class="dropdown-menu" aria-labelledby="dropdown-documentos">
                    <?php foreach($menu_doc as $header => $items): ?>
                        <?php if(count($items) > 0): ?>
                            <h6 class="dropdown-header"><?= $header ?></h6>
                            <?php foreach($items as $l => $i): ?>
                                <a class="dropdown-item" <?php if($i['type'] == 'attachment') echo 'target="__blank"' ?> href="<?= $i['url'] ?>"><?= $l ?></a>
                            <?php endforeach ?>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            </li>
        </ul>

        <ul class="navbar-nav d-lg-none">
            <li class="nav-item">
            <a class="btn btn-outline-light" href="<?= get_home_url() ?>">Home</a>&nbsp;
            </li>
            <li class="nav-item">
            <a class="btn btn-outline-light" href="<?= get_permalink(get_page_by_path("biblioteca")) ?>">Biblioteca</a>&nbsp;
            </li>
            <li class="nav-item">
            <a class="btn btn-outline-light" href="<?= get_permalink(get_page_by_path("equipe-escolar")) ?>">Equipe Escolar</a>&nbsp;
            </li>
            <li class="nav-item">
                <a class="btn btn-outline-light" href="<?= get_permalink(get_page_by_path("contatos")) ?>">Contatos</a>&nbsp;
            </li>
        </ul>
        </div>
    </nav>