<section>
    <h2>Details des épisodes</h2>

    <article>
        <h3>Épisode <?=$data['episode']['title']?></h3>
        <p><?=$data['episode']['content']?></p>
        <p class="pCreatedAt">Écrit le <?=$data['episode']['episode_created_the']?></p>
    </article>
</section>
<!--  Whoops \ Exception \ ErrorException (E_NOTICE)
Undefined index: title 
 5
Whoops\Exception\ErrorException
…\templates\frontoffice\detailofepisode.html.php5
-->
<section>
    
    <h4>Commentaires</h4>
    
    <article>
        <p>Pseudo : <?=$comment['pseudo']?></p>
        <p>Commentaire : <?=$comment['comment']?></p>
        <p>Publié le : <?=$comment['comment_created_the']?></p>
    </article>
    
</section>

<section>
    <article>
        <h4> Publier un commentaire : </h4>

        <form action="index.php?action=addcomment&id=<?=$post['id']?>" method="post">
                <div>
                    <label for="pseudo">Votre pseudo : </label><br />
                    <input type="text" id="pseudo" name="pseudo" />
                </div>
                <div>
                    <label for="comment">Votre commentaire : </label><br />
                    <textarea id="comment" name="comment" rows="10" cols="62">
                        Commentaire
                    </textarea>
                </div>
                <div>
                    <input type="submit" class="inputTypeSubmitPublishComment" value="Publier" />
                </div>
        </form>
    </article>
</section>