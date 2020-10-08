<div class="wrap">
    <h1 class="heading-inline">Liste des épisodes</h1>
    <a class="page-title-action" href="index.php?action=postNew">Ajouter</a>
    <hr class="header-end">
    <h2 class="screen-reader-text">Filtrer la liste des épisodes</h2>
    <ul class="subsubsub">
	    <li class="all"><a href="index.php?action=post" class="current" aria-current="page">Tous <span class="count">()</span></a> |</li>
	    <li class="publish"><a href="index.php?action=publish">Publiés <span class="count">()</span></a> |</li>
    </ul>
    <form id="posts-filter" method="get">
        <p class="search-box">
            <label class="screen-reader-text" for="post-search-input">Rechercher des épisodes:</label>
            <input type="search" id="post-search-input" name="s" value="">
            <input type="submit" id="search-submit" class="button" value="Rechercher des épisodes">
        </p>
        <h2 class="screen-reader-text">Liste des épisodes</h2>
        
            <table class="list-table widefat fixed striped table-view-list posts">
                <thead>
                    <tr>
                        <th id="title" class="manage-column column-title column-primary sortable desc" scope="col">
                            <a href="index.php?action=edit.php?orderby=title&amp;order=asc"><span>Titre</span><span class="sorting-indicator"></span></a>
                        </th>
                        <th id="numberEpisode" class="manage-column column-numberEpisode sortable desc">
                            <a href="index.php?action="><span>Numéro de l'épisode</span><span class="sorting-indicator"></span></a>
                        </th>
                        <th id="date" class="manage-column column-date sortable asc">
                            <a href="index.php?action="><span>Date</span><span class="sorting-indicator"></span></a>
                        </th>
                        <th id="introduction" class="manage-column column-introduction">
                            <a href="index.php?action="><span>Introduction</span><span class="sorting-indicator"></span></a>
                        </th>
                        <th id="edit" class="manage-column column-edit">
                            <a href="index.php?action=postEdit"><span>Éditer</span><span class="sorting-indicator"></span></a>
                        </th>
                        <th id="delete" class="manage-column column-delete">
                            <a href="index.php?action="><span>Supprimer</span><span class="sorting-indicator"></span></a>
                        </th>
                    </tr>
                </thead>

                <?php foreach($data['allposts'] as $post): ?>
                    <tbody id="the-list">
                        <tr>
                            <td class="title column-title has-row-actions column-primary page-title" data-colname="Titre">
                                <strong>
                                    <a class="row-title" href="" aria-label=""><?=$post['title']?></a>
                                </strong>
                            </td>
                            <td class="chapter column-chapter" data-colname="Numéro de l'épisode">
                                <?=$post['chapter']?>
                            </td>
                            <td class="date column-date" data-colname="Date">
                                Publié
                                <br>
                                <?=$post['post_date_fr']?>
                            </td>
                            <td class="introduction column-introduction" data-colname="Introduction">
                                <?=$post['introduction']?>
                            </td>
                            <td class="edit column-edit" data-colname="Éditer">
                                <!-- /post.php?post=383&action=edit -->
                                <strong>
                                    <a class="row-title" href="index.php?action=postEdit" aria-label="Modifier">Editer</a>
                                </strong>
                            </td>
                            <td class="delete column-delete" data-colname="Supprimer">
                                <strong>
                                    <a class="row-title" href="index.php?action=postDelete" aria-label="Supprimer">Supprimer</a>
                                </strong>
                            </td>
                        </tr>
                    </tbody>
                <?php endforeach; ?>
            </table>
    </form>
</div>