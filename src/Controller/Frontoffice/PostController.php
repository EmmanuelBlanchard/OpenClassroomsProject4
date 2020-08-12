<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\Model\CommentManager;
use App\Model\PostManager;
use App\View\View;

class PostController
{
    private PostManager $postManager;
    private CommentManager $commentManager;
    private View $view;

    public function __construct(PostManager $postManager, CommentManager $commentManager, View $view)
    {
        $this->postManager = $postManager;
        $this->commentManager = $commentManager;
        $this->view = $view;
    }

    public function displayOneAction(int $id): void
    {
        $data = $this->postManager->showOne($id);

        if ($data !== null) {
            $this->view->render(['template' => 'post','onepost' => $data]);
        } elseif ($data === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, ce post n\'existe pas</h1><a href="index.php?action=home">Accueil</a><br>';
        }
    }

    public function displayAllAction(): void
    {
        $data = $this->postManager->showAll();

        if ($data !== null) {
            $this->view->render(['template' => 'posts', 'allposts' => $data]);
        } elseif ($data === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }
    }

    public function displayHomeWithTheLastThreeEpisodes(): void
    {
        $data = $this->postManager->showLastThreeEpisodes();
        /*
        echo"<pre>";
        print_r($data);
        echo"</pre>";
        die();*/

        if ($data !== null) {
            $this->view->render(['template' => 'home', 'allposts' => $data]);
        } elseif ($data === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }
    }

    public function displayListOfEpisodes(): void
    {
        $data = $this->postManager->showAllEpisodes();

        if ($data !== null) {
            $this->view->render(['template' => 'listofepisodes', 'allposts' => $data]);
        } elseif ($data === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }
    }
    
    public function displayDetailOfEpisode(int $id): void
    {
        $episode = $this->postManager->findId($id);
        // $commentaires= $this->commentManager->findAllEpisode($id);
        $comments = $this->commentManager->getComments($id);

        //echo"<pre>";
        //print_r($episode);
        //print_r($comments);
        //echo"</pre>";
        //die();

        // Start Display $episode =>
        /*
        Array
(
    [id] => 1
    [title] => I - CHAPITRE PRÉLIMINAIRE
    [introduction] =>

Il y a quelques années, le R. P. Lacombe, l’organisateur de l’excursion que nous allons raconter, était missionnaire dans l’extrême-ouest de la région des prairies, à Calgary.

 Un jour, il reçut de Winnipeg une dépêche ainsi conçue : « Venez dîner avec moi, demain soir, dans mon char-palais, à Calgary. — Geo. Stephen.» Le P. Lacombe en croyait à peine ses yeux ; car le chemin de fer, plus ou moins complété dans la prairie, n’était pas encore en opération. Mais, le lendemain, il n’y avait plus à douter : un train spécial arrivait à Calgary, après avoir franchi l’immense prairie en 32 heures.

    [content] =>

Il y a quelques années, le R. P. Lacombe, l’organisateur de l’excursion que nous allons raconter, était missionnaire dans l’extrême-ouest de la région des prairies, à Calgary.

Un jour, il reçut de Winnipeg une dépêche ainsi conçue : « Venez dîner avec moi, demain soir, dans mon char-palais, à Calgary. — Geo. Stephen.» Le P. Lacombe en croyait à peine ses yeux ; car le chemin de fer, plus ou moins complété dans la prairie, n ’était pas encore en opération. Mais, le lendemain, il n ’y avait plus à douter : un train spécial arrivait à Calgary, après avoir franchi l’immense prairie en 32 heures.

Le bon missionnaire se hâta de venir souhaiter la bienvenue aux distingués visiteurs. Sir George Stephen — qui à cette époque n’était pas encore arrivé à la prairie — vint au devant de lui, et lui serra la main ; et comme le Père le félicitait sur sa course rapide à travers les prairies, et sur les progrès de sa grande entreprise, sir George, avec un entrain plein de gaieté et d’humour, lui montra la formidable chaîne des Rocheuses, dont les cimes blanches et grises dentelaient l’horizon d’azur :

 — Qu’est-ce que c’est que cela, demanda-t-il ?

 — Ce sont les Montagnes Rocheuses, Sir George.

 — Est-ce qu’elles prétendent nous barrer le chemin ?

 — Peut-être.

 — Nous le verrons bien ; mais si elles ne s’écartent pas, nous leur passerons sur le dos.

 Dans ce voyage, Sir George Stephen avait avec lui plusieurs autres membres du syndicat du Pacifique, trois présidents de compagnies américaines de chemin de fer, quelques Lords anglais et un comte allemand, frère du cardinal Hohenlobe.

 Dans un magnifique char, vide de bancs, une table somptueuse était servie, et le président du Pacifique plaça le P. Lacombe à sa droite. Le dîner fut princier et des plus gais.

 Plusieurs santés furent proposées, entre autres celle du P. Lacombe, qui n’aime guère faire des discours, mais qui dut prendre la parole :

 « Dans les coutumes de nos sauvages, dit-il, on ne doit pas commencer un discours sans donner d’abord une poignée de main à son hôte, et comme un vieux sauvage que je suis, je demande, M. le Président, de vous serrer la main. »

 Cette formalité chaleureusement remplie, l’orateur remercia les illustres visiteurs de l’honneur qui lui était fait, mais il restitua cet honneur à ceux qu’il était présumé représenter, à l’Église catholique, dont il était l’humble ministre, à ses compatriotes Canadiens-Français, les premiers maîtres du Canada, à ses chers Indiens, les premiers habitants des vastes territoires du Nord-Ouest.

 Il félicita les membres du Syndicat du Pacifique de l’esprit d’entreprise et de l’activité qu’ils déployaient dans la construction de leur merveilleux chemin de fer, et il leur montra la mission civilisatrice qu’ils auraient à remplir dans l’immense pays qu’ils allaient traverser.

 Il s’applaudit de les avoir aidés de son influence dans une circonstance récente, et il exprima l’espoir qu’ils l’aideraient à leur tour dans son œuvre d’évangélisation…

 M. Angus se leva alors, et, dans les termes les plus aimables, remercia le missionnaire de ses bonnes paroles. Puis, après quelques phrases élogieuses, il proposa que le R. P. Lacombe fût élu président de la compagnie du Pacifique, et il ajouta que Sir George Stephen pourrait peut-être le remplacer comme chapelain de la mission de Calgary.

 La proposition fut accueillie avec enthousiasme. Tous les convives, debout, verres en mains, acclamèrent le nouveau président.

 Sir George Stephens déclara qu’il cédait de bonne grâce tous ses droits et privilèges au nouvel élu, et qu’il acceptait la nouvelle position qu’on lui proposait. Et, se tournant vers Calgary, il termina en disant : “ Poor souls of Calgary, I pity you ! ”

 Le lendemain matin, les distingués touristes reprenaient la route de Winnipeg, emmenant avec eux le P. Lacombe, qu’ils déposèrent à 40 milles de Calgary, au milieu de la prairie, où l’appelait son ministère de missionnaire.

 Il avait été président de la compagnie du Pacifique Canadien pendant une heure ; mais ce grand honneur l’avait peut-être empêché de dormir, et il revenait à des fonctions à la fois plus humbles et plus élevées. Car lorsqu’il traversait à cheval ces immenses solitudes, devenues sa patrie, les Indiens disaient de lui : c’est le représentant du Grand Esprit qui passe !

 Quels ambitieux que ces missionnaires ! Ils ont des aspirations bien plus hautes que la présidence d’une compagnie de chemin de fer — fût-elle la compagnie du Pacifique Canadien. Et quand, chevauchant dans la prairie à la recherche des âmes, ils se demandent avec la sainte ambition des apôtres : quo non ascendam ? Ils peuvent se répondre à eux-mêmes : Je monterai sur la montagne de Sion, auprès de laquelle les Rocheuses ne sont que des grains de sable !

 II

 Évidemment, la cordialité de cette rencontre entre les membres du syndicat et le P. Lacombe fait présumer des relations antérieures ; et, de fait, ces relations remontaient déjà à quelques années.

 Dès les commencements de l’exécution de cette vaste entreprise, et alors que le tracé du chemin n’était pas encore définitivement fixé, le P. Lacombe avait rencontré au Portage-du-Rat plusieurs des directeurs du Pacifique qui s’y trouvaient réunis. Ils délibéraient sur la route à suivre à partir de Winnipeg, et ils avaient mandé le vieux missionnaire pour connaître son avis.

 Le Père conseillait d’aller tout droit de Winnipeg à Brandon ; mais, à partir de Brandon, il croyait que le chemin devrait se diriger vers le Nord pour atteindre la Saskatchewan, passer par Edmonton, gagner vers la rivière Athabaska et franchir les Rocheuses. C’était l’ancienne route suivie par les Bourgeois du Nord-Ouest, par les voyageurs, et par les missionnaires.

 Après l’avoir entendu, Sir George Stephen dit : vos raisons, Père, sont excellentes, sans doute, au point de vue de la colonisation des Territoires ; car nous traverserions ainsi, d’après ce que vous nous dîtes, des régions plus avantageuses comme pays agricole. Mais nous pourrons atteindre plus tard ces régions-là par des embranchements. Pour le moment, il nous faut une ligne plus courte. Et, prenant un crayon, Sir George traça sur la carte étendue devant lui une grande ligne presque droite de Winnipeg à Calgary, et dit : voilà le tracé que nous devons suivre.

 Quelque temps après, les travaux se poursuivaient avec une rapidité étonnante, et le chemin s’étendait à travers les prairies, à raison de 6 à 7 milles par jour.

 Un personnel nombreux d’ingénieurs, d’entrepreneurs, de terrassiers et autres travailleurs sillonnait la plaine, entraînant avec eux des voituriers et des marchands de provisions. En même temps une ligne télégraphique était construite le long de la voie, afin que les travailleurs pussent rester en communication avec le bureau général, et recevoir ses ordres.

 Mais, arrivés auprès de l’endroit où se trouve aujourd’hui Gleichen, les travailleurs allaient entrer sur la réserve des sauvages établis à Blackfoot Crossing (gué sur la rivière de l’Arc), et qui avaient pour chef le célèbre Pied-de-Corbeau (Crowfoot).

 Naturellement, ces sauvages n’étaient pas du tout disposés à souffrir qu’on s’emparât d’une lisière de leur réserve. Tout préparés à la résistance, ils pouvaient mettre sur pieds quinze cents guerriers bien armés, et massacrer les travailleurs du Pacifique.

 Mis au courant de qui se passait, le P. Lacombe monta à cheval, et courut avertir les travailleurs du danger qui les menaçait. En même temps, il leur demanda quelque délai pour apaiser les sauvages, et les disposer à quelqu’arrangement. Mais les travailleurs répondirent que cela ne les regardait pas, et quelques-uns dirent : “ Let your dirty Indians go to the devil ! ”

 Un massacre paraissait inévitable, et il n’y avait pas une heure à perdre pour le prévenir. Le P. Lacombe adressa dépêches sur dépêches aux autorités du Pacifique, et, quant il eut obtenu les réponses qu’il désirait, voici ce qu’il fit.

 Il acheta 200 livres de sucre, autant de tabac, du thé, et plusieurs sac de farine ; et, de retour à la mission, il convoqua tous ses Indiens à un Grand Conseil.

 Quand il furent réunis, il donna toutes ces provisions aux chefs pour être distribués entre les familles ; et quand le partage fut fait, il prit la parole : « Maintenant, leur dit-il, j’ai la bouche ouverte, (car pour avoir le droit de parler, d’après les coutumes sauvages, il faut d’abord faire un présent), et je vous prie de prêter l’oreille à mes paroles.

 « S’il y en a un parmi vous qui puisse dire que pendant les quinze années que j’ai passées au milieu de vous je lui ai donné un mauvais conseil, qu’il se lève et le dise sans crainte. » — Personne ne se leva. —

 « Eh ! bien, mes amis, j’ai aujourd’hui un conseil à vous donner : laissez passer les Blancs sur vos terres, et y faire les travaux nécessaires à leur chemin ; ils ne peuvent toujours pas vous les enlever.

 « D’ailleurs, ces Blancs qui passent ne sont que des travailleurs, obéissant à des chefs, et c’est avec ces chefs qu’il faut régler la difficulté.

 « Je leur ai fait connaître votre mécontentement, et dans quelques jours le Gouverneur lui-même viendra vous voir. Il entendra vos plaintes, et, si l’arrangement qu’il vous proposera ne vous convient pas, il sera temps encore de garder vos terres et d’en expulser les travailleurs… »

 Crowfoot — ce sauvage intelligent qui a visité depuis la province de Québec, et que toute la presse a loué — prit alors la parole, et déclara que le conseil du Chef-de-la-Prière était bon, et qu’il faillait le suivre.

 En conséquence, les projets de résistance furent abandonnés ; et les employés du chemin de fer purent traverser la Réserve sans être aucunement molestés.



 Quelques jours après, comme l’avait annoncé le P. Lacombe, le Lieutenant-Gouverneur Dewdney vint rendre visite aux sauvages, et leur dit : « Vous avez bien agi, et je vous en remercie, Voici maintenant ce que je viens vous proposer : en échange de la terre que le chemin de fer va prendre sur la lisière de votre Réserve, je vais vous en donner cent fois autant en arrière de cette Réserve ; et, si vous ne voulez pas, nous allons défaire les travaux commencés, et tracer le chemin en dehors. »

 Tous se déclarèrent satisfaits, et la Réserve fut agrandie en conséquence du côté du Nord.

 Mais, en même temps, les directeurs du chemin de fer du Pacifique Canadien comprirent qu’ils devaient quelque reconnaissance au P. Lacombe, et ils la lui témoignèrent à plusieurs reprises, de diverses manières.

 III

 Un jour — il y a 7 ou 8 ans — le R. Père se trouvant à Montréal, fut mandé dans les magnifiques bureaux de la grande Compagnie, où la plupart des directeurs étaient réunis.

 Après les salutations d’usage, et l’échange de quelques paroles courtoises, on lui fit une surprise fort agréable.

 Une porte à deux battants s’ouvrit, et deux domestiques entrèrent, portant une grande peinture, magnifiquement encadrée. C’était un tableau de grand prix, importé de Florence, et représentant la Madone portant l’enfant Jésus dans ses bras.

 M. Angus adressa alors au P. Lacombe quelques phrases pleines de tact et d’esprit, appropriées à la circonstance, et lui offrit le tableau, au nom des directeurs, pour la chapelle de Notre-Dame de Calgary.

 Depuis lors, l’intimité des rapports amicaux entre les magnats du Pacifique et le P. Lacombe n’a fait que s’accroître, et il va sans dire que l’excellent missionnaire voyage gratis sur leur chemin aussi souvent qu’il lui plaît.

 Cette année, il a fait le projet de mettre à contribution, la libéralité et la généreuse bienveillance que lui témoigne le président actuel de la compagnie, M. Van Horne ; et il a organisé une excursion épiscopale qui a été couronnée d’un plein succès.

 Évidemment, il avait en vue autre chose qu’un voyage de plaisir, et l’idée mère qui a présidé à cette organisation était d’un ordre plus élevé.

 C’est l’Église de la province de Québec qui a donné naissance aux missions du Nord-Ouest. C’est elle qui a délégué vers les tribus païennes de ces immenses territoires de nombreux messagers de la Bonne Nouvelle, et sous son égide l’œuvre évangélisatrice a prospéré — avec l’aide de l’Église de France et de l’admirable congrégation des Oblats de Marie Immaculée.

 Aujourd’hui, l’Église de l’Ouest a voulu montrer ses œuvres à celle de l’Est, et lui témoigner sa gratitude. C’étaient les enfants qui voulaient donner l’hospitalité à leurs pères, en leur disant : venez voir ce que nous sommes devenus, grâce à votre impulsion paternelle, et ce que nous pouvons devenir, si vous voulez favoriser notre développement par les moyens à votre disposition.

 Il y avait donc autre chose qu’un tableau touchant, dans cette affectueuse accolade des pères et des enfants, que le P. Lacombe a préparée, et dont nous avons été l’heureux témoin. Un tel rapprochement avait un côté pratique, et produira certainement des résultats appréciables dans l’avenir.

 Resserrer les liens qui unissent déjà les catholiques de l’Est à ceux de l’Ouest, faire mieux connaître dans les provinces de l’Est les incontestables richesses inexploitées de l’Ouest, développer le sentiment d’émulation patriotique qui doit nous animer tous pour l’agrandissement de notre commune patrie — le Canada — tels sont les fruits que le promoteur de l’excursion pouvait espérer produire.

 M. Van Horne a accueilli ce projet avec un empressement et une courtoisie qui lui font honneur ; et, disons-le, en agissant comme il l’a fait, il a donné une nouvelle preuve, non-seulement de sa libéralité, mais aussi de sa haute intelligence des affaires. Il n’a pas vu seulement aujourd’hui, il a vu demain.

 Un magnifique char-palais a été mis gratuitement à la disposition des excursionnistes, et sur tout le parcours de la voie des ordres ont été donnés pour qu’ils fussent traités convenablement.

 Aussi le voyage a-t-il été des plus agréables, comme ce récit en fera foi.

 Voici les noms de tous ceux qui prirent part à cette excursion, avec l’auteur de ce livre :

 S. G. Mgr Taché, archevêque de Saint-Boniface ;

 S. G. Mgr Duhamel, archevêque d’Ottawa ;

 S. G. Mgr Laflêche, évêque de Trois-Rivières ;

 S. G. Mgr Macdonald, évêque d’Alexandria ;

 S. G. Mgr Brondel, évêque d’Helena, Montana ;

 S. G. Mgr Grouard, vicaire apostolique d’Athabaska-Mackenzie ;

 S. G. Mgr Lorrain, évêque de. Pontiac ;

 Mgr Hamel, protonotaire apostolique, représentant S. E. le cardinal archevêque de Québec ;

 M. le vicaire général Maréchal, représentant Mgr l’archevêque de Montréal ;

 M. le chanoine Bouleau, représentant Mgr l’évêque de Bimouski ;

 Le R. P. McGuckin, 0. M. I., recteur de l’Université d’Ottawa ;

 Le R. P. Royer, 0. M. I., de la maison des Pères, à Québec ;

 Le R. P. Gendreau, 0. M. I., procureur de la maison des Pères, à Montréal ;

 Le Rév. M. Leclerc, curé de Saint-Joseph de Montréal ;

 Le Rév. M. Vézina, curé des Trois-Pistoles ;

 Le Rév. M. Séguin, curé de Sainte-Cunégonde ;

 Le Rév. M. Collet, préfet des études, au collège de Sainte-Anne ;

 Le Rév. M. Auclair, curé de Saint-Jean-Baptiste ;

 Le Rév. M. Marchand, des Trois-Rivières ;

 Le R. P. Catulle, Supérieur de la Congrégation des P. P. Rédemptoristes, de Belgique ;

 Le Rév. P. Allard, V. G. de Saint-Boniface ;

 Enfin, le R. P. Lacombe, 0. M. I. — the last but not the least — notre infatigable capitaine, et notre chef à tous dans ce char pittoresque, que nous appelions le char d’Israël.

 D’autres Religieux et prêtres se joignirent à nous, à diverses étapes de notre excursion, et firent avec nous une partie du trajet ; mentionnons entre autres les Rév. MM. Morin, Caron et Blanchet, et les PP. Beaudin, du Portage-du-Rat, Leduc, de Calgary, Gabillon, du Lac aux Canards, Chirouse et Lejeune des missions de la Colombie.

 D’autres encore, accompagnant Mgr Durieu, évêque de New-Westminster, et Mgr Lemmens, évêque de Victoria, vinrent nous rencontrer à la mission Sainte-Marie.

 On devra reconnaître qu’une pareille réunion d’hommes est fort rare, et qu’il s’écoulera peut-être des siècles avant que les territoires du Nord-Ouest revoient des spectacles comme ceux qui leur ont alors été donnés.

 La presse entière du Canada, et beaucoup de journaux des États-Unis en ont parlé comme d’un événement de la plus grande importance, et ce livre, n’eût-il pour objet que d’en perpétuer le souvenir, aurait sa raison d’être et son utilité.

    [episode_created_the] => 2020-07-26 17:57:00
)

    End of display $episode

    Start of display $comments =>

Array
(
    [0] => Array
        (
            [episode_id] => 1
            [pseudo] => alexandre.thibault
            [comment] =>

Est quod qui nisi consequatur voluptatem accusantium voluptate. Enim aut veniam dolor veritatis quis. Velit rerum aliquam dolorem aperiam enim debitis.

Inventore ducimus nisi omnis rerum nemo facere nihil neque. Consectetur est delectus natus dolor veniam voluptatem sit est. Laudantium sit totam unde dolor. Omnis rerum sapiente quia nihil aut. Corrupti molestiae nisi hic voluptatem repudiandae.

Labore eum ipsa quam asperiores molestiae pariatur. Sed at voluptas dignissimos sint ut assumenda. Labore deserunt deserunt quia iure facilis qui.

Sequi est id voluptate unde distinctio doloremque non sequi. Qui omnis temporibus non eum nesciunt. Sunt vel ipsam quisquam explicabo magni alias. Qui non ut et occaecati. Reiciendis excepturi minus aut qui beatae non soluta.

Pariatur aperiam dolore aut. Eos minima harum sed nobis placeat molestias dolor assumenda. Atque sed nisi sit ratione occaecati unde ad. Ad dolores corrupti sit quo consequatur qui.

            [comment_created_the] => 2020-06-17 05:03:02
        )

    [1] => Array
        (
            [episode_id] => 1
            [pseudo] => delahaye.augustin
            [comment] =>

Et laborum ut ducimus eum odio est ut. Eos aspernatur aut sit id et sed. Rerum est molestiae pariatur deleniti sapiente rerum nesciunt.

Temporibus ullam quia expedita veritatis dolor in. Deserunt et corporis omnis quis autem reprehenderit. Doloribus et similique ea accusamus rerum nihil quo.

Repellendus aperiam ut in quaerat cum. Dolores exercitationem veniam adipisci qui. Non quia aut dolores a quae rerum. Consectetur ut laboriosam fuga minima harum. Et quia et rerum possimus veritatis voluptatum delectus omnis.

Praesentium et nam ad quis repudiandae ut. Cupiditate delectus qui modi aut. Iusto et facere voluptas ad.

Aperiam sit qui dolore qui et. Ut quo sit dolores consequuntur. Rerum animi mollitia nostrum qui. Voluptas dolorem aut placeat nisi.

            [comment_created_the] => 2020-06-13 14:40:15
        )

)
        */

        if ($episode !== null) {
            $this->view->render(['template' => 'detailofepisode', 'episode' => $episode, 'allcomment' => $comments]);
        } elseif ($episode === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }
    }

    public function addComment(int $id, string $pseudo, string $comment): void
    {
        $episode = $this->commentManager->postComment($id, $pseudo, $comment);

        if ($episode !== null) {
            $this->view->render(['template' => 'detailofepisode', 'episode' => $episode]);
        } elseif ($episode === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, Impossible d\'ajouter le commentaire !</h1><a href="index.php?action=home">Accueil</a><br>';
        }
    }
}
