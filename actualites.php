<?php require_once "core/header.php"; ?>
<?php require_once "core/navigation.php"; ?>
<section class="tj-contact-section">
    <?php $colors = array("red", "yellow"); ?>
    <div class="container">
        <div class="row">
            <?php if (isset($_GET['action']) && $_GET['action'] === "read") {
                $pickedColor = $colors[array_rand($colors)];
                try {
                    $date = new DateTime($actu['created_at']);
                    $date = $date->format('d/m/Y à H\hi');
                } catch (Exception $e) {
                    $date = "Date inconnue";
                }
                ?>
                <div class="tj-heading-style">
                    <h3><?= $actu['title'] ?></h3>
                </div>
                <div class="col-md-2 col-sm-2 hidden-xs"></div>
                <div class="col-md-8 col-sm-8">
                    <article class="postcard light <?= $pickedColor ?>" style="flex-direction: column">
                        <a class="postcard__img_link" title="<?= $actu['title'] ?>">
                            <img class="postcard__img" src="<?= $actu['image'] ?>" alt="<?= $actu['title'] ?> Image" loading="lazy"/>
                        </a>
                        <div class="postcard__text t-dark">
                            <h1 class="postcard__title <?= $pickedColor ?>"><a><?= $actu['title'] ?></a></h1>
                            <div class="postcard__subtitle small">
                                <time datetime="<?= $actu['created_at'] ?>">
                                    <i class="fas fa-calendar-alt mr-2"></i> Ecrit le <?= $date ?>
                                </time>
                            </div>
                            <div class="postcard__bar"></div>
                            <div class="postcard__preview-txt">
                                <?= $actu['actu_html'] ?>
                            </div>
                            <ul class="postcard__tagbox" style="justify-content: end;">
                                <li class="tag__item play">
                                    <a href="/actualites" title="Retour actualités"><i class="fas fa-arrow-left mr-2"></i> Retour</a>
                                </li>
                            </ul>
                        </div>
                    </article>

                </div>
                <div class="col-md-2 col-sm-2 hidden-xs"></div>
            <?php } elseif (isset($_GET['action']) && $_GET['action'] === "create") { ?>
                 <?php
                if (isset($_POST['createActu'])) {
                    $title = $_POST['title'];
                    $content = $_POST['content'];
                    $image = $_POST['image'];
                    $description = $_POST['description'];
                    $keywords = $_POST['keywords'];

                    $actu = createActualite($title, $content, $image, $description, $keywords);
                    if ($actu) {
                        echo '<div class="alert alert-success" role="alert">Actualité créée avec succès !</div>';
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Une erreur est survenue lors de la création de l\'actualité.</div>';
                    }
                }
                ?>
                <div class="tj-heading-style">
                    <h3>Création d'un article</h3>
                </div>
                <div class="col-md-2 col-sm-2 hidden-xs"></div>
                <div class="col-md-8 col-sm-8">
                    <form method="post" action="/actualite/create"
                        <article class="postcard light cb-frm" style="flex-direction: column">
                            <div class="postcard__text t-dark">
                                <h1 class="postcard__title">
                                    <div class="info-field">
                                        <label>URL Image</label>
                                        <input type="text" name="image" placeholder="Entrez une URL d'image (format bannière)" required/>
                                    </div>
                                    <div class="info-field">
                                        <label>Titre</label>
                                        <input type="text" name="title" placeholder="Entrez un titre d'article" required/>
                                    </div>

                                    <div class="info-field">
                                        <label>Meta Description</label>
                                        <input type="text" name="description" placeholder="Entrez la description de l'article (pour la balise meta)" required/>
                                    </div>

                                    <div class="info-field">
                                        <label>Meta Keywords</label>
                                        <input type="text" name="keywords" placeholder="Entrez les mots clés de l'article séparés par une virgule (pour la balise meta)" required/>
                                    </div>
                                </h1>
                                <div class="postcard__preview-txt">
                                    <div class="info-field">
                                        <label for="editor">Contenu</label>
                                        <textarea name="content" id="editor"></textarea>
                                        <script>
                                            ClassicEditor
                                                .create( document.querySelector( '#editor' ) )
                                                .then( editor => {
                                                    console.log( editor );
                                                } )
                                                .catch( error => {
                                                    console.error( error );
                                                } );
                                        </script>
                                    </div>
                                </div>
                                <ul class="postcard__tagbox">
                                    <li class="tag__item play">
                                        <button type="submit" name="createActu" style="background-color:transparent;outline:none;border:none;"><i class="fas fa-plus-circle mr-2"></i> Créer</button>
                                    </li>
                                </ul>
                            </div>
                        </article>
                    </form>
                </div>
                <div class="col-md-2 col-sm-2 hidden-xs"></div>
            <?php } else { ?>
                <div class="tj-heading-style">
                    <h3>Actualités</h3>
                </div>
                <div class="col-md-12 col-sm-12 articles-container">
                    <?php $actualites = getActualites();

                    foreach ($actualites as $actu) {
                        $pickedColor = $colors[array_rand($colors)];
                        $acturl = $actu['id'] . "-" . sluggify($actu['title']);
                        try {
                            $date = new DateTime($actu['created_at']);
                            $date = $date->format('d/m/Y à H\hi');
                        } catch (Exception $e) {
                            $date = "Date inconnue";
                        }
                        ?>
                        <article class="postcard light <?= $pickedColor ?>">
                            <a class="postcard__img_link" href="/actualite/<?= $acturl ?>" title="Couverture <?= $actu['title'] ?>">
                                <img class="postcard__img" src="<?= $actu['image'] ?>" alt="<?= $actu['title'] ?> Image" loading="lazy"/>
                            </a>
                            <div class="postcard__text t-dark">
                                <h1 class="postcard__title <?= $pickedColor ?>"><a href="/actualite/<?= $acturl ?>"><?= $actu['title'] ?></a></h1>
                                <div class="postcard__subtitle small">
                                    <time datetime="<?= $actu['created_at'] ?>">
                                        <i class="fas fa-calendar-alt mr-2"></i> Ecrit le <?= $date ?>
                                    </time>
                                </div>
                                <div class="postcard__bar"></div>
                                <div class="postcard__preview-txt">
                                    <?= (strlen($actu['actu']) > 100) ? substr($actu['actu'], 0, 100) . "..." : $actu['actu'] ?>
                                </div>
                                <ul class="postcard__tagbox">
                                    <li class="tag__item play <?= $pickedColor ?>">
                                        <a href="/actualite/<?= $acturl ?>" rel="dofollow" title="<?= $actu['title'] ?>"><i class="fas fa-play mr-2"></i> Lire l'article</a>
                                    </li>
                                </ul>
                            </div>
                        </article>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php require_once "core/footer.php"; ?>
