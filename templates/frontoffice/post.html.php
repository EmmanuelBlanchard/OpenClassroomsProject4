    <a href="index.php?action=post&id=100">Un post qui existe</a>
    <br> 
    <a href="index.php?action=post&id=1000">Un post qui n'existe pas</a>
    <article>
        <h2><?=$data['onepost']['title']?></h2>
        <p><?=$data['onepost']['text']?></p>
    </article>
