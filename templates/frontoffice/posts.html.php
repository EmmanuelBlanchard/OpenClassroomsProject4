<section>
    <h2>Tous les épisodes</h2>

    <?php foreach($data['allposts'] as $post): ?>
    <p>id = <?=$post['id']?></p>
    <p>title = <?=$post['title']?></p>
    <p>introduction = <?=$post['introduction']?></p>
    <a href="index.php?action=post&id=<?=$post['id']?>\" class="linkToTheRestOfThePost">Lire la suite</a>
   
</section>
<?php endforeach; ?>