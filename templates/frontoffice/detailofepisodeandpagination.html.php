<section class="sectionDisplayEpisode">
    <h2>Details des épisodes</h2>

    <article>
        <h3>Épisode <?=$data['episode']['title']?></h3>
        <?=$data['episode']['content']?>
        <p class="pCreatedAt">Publié <?=$data['episode']['episode_date_fr']?></p>
    </article>
</section>

<section class="sectionDisplayComments">
    <h4 class="sectionH4TitleComments">Commentaires</h4>
    <?php foreach($data['allcomment'] as $post): ?>
    <article>
        <h5>Commentaire de </h5>
        <p class="pAuthorComments"><?=$post['author']?></p>
        <p class="pDateComments"><?=$post['comment_date_fr']?> </p>
        <?=$post['comment']?>
        
        <!-- if $post['report'] === '1' {
            <p>Ce commentaire a déjà été signalé</p>
        } else {
            <p><a href="index.php?action=report&commentid= $post['id'] &id= $post['episode_id'] " class="linkToTheReportOfThePostComment">Signaler</a></p>
        }
        -->

        <div class="buttonReport">
            <a href="index.php?action=report&amp;commentid=<?=$post['id']?>&amp;id=<?=$post['episode_id']?>" class="linkToTheReportOfThePostComment">Signaler</a>
        </div>
    </article>
    <?php endforeach; ?>
</section>

<section class="sectionPostComment">
    <h4 class="sectionH4TitlePostComment"> Publier un commentaire</h4>
        <form class="commentForm" method="post" action="index.php?action=addComment&amp;id=<?=$data['episode']['id']?>">
            <p class="commentFormComment">
                <label for="comment">Commentaire <span>(obligatoire)</span> </label>
                <textarea name="comment" id="comment" rows="10" cols="50" required></textarea>
            </p>
            <p class="commentFormAuthor">
                <label for="author">Nom <span>(obligatoire)</span> </label>
                <input id="author" name="author" type="text" value="" size="30" maxlength="245" required>
            </p>
            <p>
                <input type="submit" class="inputTypeSubmitPublishComment" value="Publier" />
            </p>
        </form>
</section>

<!-- Essai Pagination -->
<p id="pagination">
				<?php

				echo 'Page : ';
                // Undefined variable: totalpagecomments
				for ($i = 1 ; $i <= $data['totalpagecomments'] /*$totalpagecomments*/ ; $i++)
				{
					if ($i == $data['page'] /*$page*/)
					{
						echo '<strong class="brown">' . $i . '<strong></a> ';
					}
					else
					{
						echo '<a href="index.php?action=postfront&page=' . $i . '&id='.htmlspecialchars($data['episode']['id']/*$post['id']*/).'">' . $i . '</a> ';
					}

				}
				?>
</p>

<!-- Essai Cours , si peux etre utile et etre utiliser -->
<?php
$coordonnees = array (
    'prenom' => 'François',
    'nom' => 'Dupont',
    'adresse' => '3 Rue du Paradis',
    'ville' => 'Marseille');

if (array_key_exists('nom', $coordonnees))
{
    echo 'La clé "nom" se trouve dans les coordonnées !';
}

if (array_key_exists('pays', $coordonnees))
{
    echo 'La clé "pays" se trouve dans les coordonnées !';
}

?>

<?php
$fruits = array ('Banane', 'Pomme', 'Poire', 'Cerise', 'Fraise', 'Framboise');

if (in_array('Myrtille', $fruits))
{
    echo 'La valeur "Myrtille" se trouve dans les fruits !';
}

if (in_array('Cerise', $fruits))
{
    echo 'La valeur "Cerise" se trouve dans les fruits !';
}
?>

<?php
$fruits = array ('Banane', 'Pomme', 'Poire', 'Cerise', 'Fraise', 'Framboise');

$position = array_search('Fraise', $fruits);
echo '"Fraise" se trouve en position ' . $position . '<br />';

$position = array_search('Banane', $fruits);
echo '"Banane" se trouve en position ' . $position;
?>

<!-- Essai pagination -->

<nav>
    <ul class="pagination">
        <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
            <a href="./?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
        </li>
        <?php for($page = 1; $page <= $pages; $page++): ?>
            <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
            <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                <a href="./?page=<?= $page ?>" class="page-link"><?= $page ?></a>
            </li>
        <?php endfor ?>
            <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
            <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
            <a href="./?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
        </li>
    </ul>
</nav>

