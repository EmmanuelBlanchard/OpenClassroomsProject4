<h2>Tous les posts</h2>
<hr>
<?php foreach($data['allposts'] as $post): ?>
<p>id = <?=$post['id']?></p>
<p>title = <?=$post['title']?></p>
<p>text = <?=$post['text']?></p>
<a href="index.php?action=post&id=<?=$post['id']?>">Lire le post</a>
<hr>
<?php endforeach; ?>