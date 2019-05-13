<?php
$categories_hierarchy[] = get_category(get_queried_object()->term_id);
while($categories_hierarchy[0]->parent != 0)
    array_unshift($categories_hierarchy, get_category($categories_hierarchy[0]->parent));
$attachments = get_posts(['category' => get_queried_object()->term_id, 'post_type' => 'attachment']);
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>ETEC Palmital</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/header.css" />
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/footer.css" />
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/default.css" />
    </head>
    <body>
        <?php get_header() ?>
        <div class="container">
        
            <h1><?php single_cat_title(); ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <?php for($i = 0;$i < count($categories_hierarchy);$i++): ?>
                    <li class="breadcrumb-item"><?= $categories_hierarchy[$i]->name ?></li>
                    <?php endfor ?>
                </ol>

                <div class="card">
                    <div class="card-body">
                        <?php foreach($attachments as $a): ?>
                        <a target="__blank" href="<?= wp_get_attachment_url($a->ID)?>"><?= $a->post_title ?></a>
                        <?php endforeach ?>
                    </div>
                </div>
            </nav>
        </div>

        <?= get_footer() ?>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html> 