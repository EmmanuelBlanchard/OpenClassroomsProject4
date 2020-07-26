<?php

declare(strict_types=1);

namespace App\Model;

class PostManager
{
    private function executeSqlDB(?int $id = null) : ?array
    {
        // *** exemple fictif d'accès à la base de données
        $data = null;
        $postTable = [];
        $postTable[1] = ['id' => 1, 'title' => 'I CHAPITRE PRÉLIMINAIRE', 'text' => '<p> Il y a quelques années, le R. P. Lacombe, l’organisateur de l’excursion que nous allons raconter, était missionnaire dans l’extrême-ouest de la région des prairies, à Calgary.</p><p> Un jour, il reçut de Winnipeg une dépêche ainsi conçue : « Venez dîner avec moi, demain soir, dans mon char-palais, à Calgary. — Geo. Stephen.» Le P. Lacombe en croyait à peine ses yeux ; car le chemin de fer, plus ou moins complété dans la prairie, n’était pas encore en opération. Mais, le lendemain, il n’y avait plus à douter : un train spécial arrivait à Calgary, après avoir franchi l’immense prairie en 32 heures.</p>
        <p> Le bon missionnaire se hâta de venir souhaiter la bienvenue aux distingués visiteurs. Sir George Stephen — qui à cette époque n’était pas encore arrivé à la prairie — vint au devant de lui, et lui serra la main ; et comme le Père le félicitait sur sa course rapide à travers les prairies, et sur les progrès de sa grande entreprise, sir George, avec un entrain plein de gaieté et d’humour, lui montra la formidable chaîne des Rocheuses, dont les cimes blanches et grises dentelaient l’horizon d’azur : </p>
        <p> — Qu’est-ce que c’est que cela, demanda-t-il ? </p>
        <p> — Ce sont les Montagnes Rocheuses, Sir George. </p>
        <p> — Est-ce qu’elles prétendent nous barrer le chemin ? </p>
        <p> — Peut-être. </p>
        <p> — Nous le verrons bien ; mais si elles ne s’écartent pas, nous leur passerons sur le dos.</p>'];

        $postTable[2] = ['id' => 2, 'title' => 'II LES PAYS-D’EN-HAUT', 'text' => '<p> C’était un spectacle fort animé que notre départ de Montréal, le 16 mai 1892, à 8 h. P. M. </p>
        <p> Le char-palais que la Compagnie du Pacifique avait généreusement mis à notre disposition était pavoisé, bien illuminé ; et, sur une draperie tendue à chaque extrémité, on lisait les mots : episcopal excursion, excursion épiscopale. À l’intérieur, une double rangée de pancartes roses, accrochées au plafond comme des pavillons, indiquait les noms des touristes et les compartiments assignés à chacun. </p>
        <p> Sur le quai, une foule énorme, composée d’amis et de curieux, attendait l’heure du départ. Les touristes saluaient leurs amis, échangeaient des poignées de mains et des paroles d’amitié, tout en s’occupant de leur installation et de leurs bagages. Les prêtres venaient dire adieu à leurs évêques, et solliciter une dernière bénédiction. </p>
        <p> Très affairé, le R. P. Lacombe — notre capitaine — allait de l’un à l’autre, s’occupant du confort de tous, et s’oubliant lui-même. </p>'];

        $postTable[3] = ['id' => 3, 'title' => 'III LE CANADA INCONNU', 'text' => '<p> Le site de North-Bay est vraiment joli, et plein de promesses pour l’avenir. En avant, le lac qui est magnifique, et qui lui donne des communications par eau avec différentes villes naissantes. En arrière, de bonnes terres à cultiver et des forêts à exploiter. </p>
        <p> Mise en communication directe avec les villes de l’Est et de l’Ouest par le chemin de fer du Pacifique, la ville naissante est reliée à Toronto par un embranchement du Grand Tronc. </p>
        <p> Sa population dépasse 5000 âmes, dont près d’un quart sont de race canadienne-française, et y possèdent une école et une chapelle. </p>
        <p> Il y a à North-Bay une Cour de District et une prison, une belle gare, de grandes usines, deux scieries, plusieurs hôtels, et quelques églises. </p>
        <p> C’est un excellent marché pour les colons des cantons voisins. </p>
        <p> À partir de cette station, la voie ferrée suit encore les bords du lac Nipissing pendant quelque temps, et nous arrivons bientôt à Sturgeon’s Falls. C’est un village florissant contenant plus de 400 familles, dont près de la moitié sont canadiennes-françaises. </p>
        <p> La jolie rivière de l’Esturgeon, qui se décharge dans le lac Nipissing, se précipite ici entre deux rochers, et forme une belle chute qui fait mouvoir plusieurs moulins. </p>'];

        $postTable[4] = ['id' => 4, 'title' => 'IV LA ROUTE DES LACS', 'text' => '<p> Quand je suis venu ici pour la première fois, en 1889, Port-Arthur portait bien son nom : c’était un port véritable, non pas précisément fait par la nature, mais confectionné par le gouvernement du Canada. Une immense jetée construite à grands frais y protége, contre les grandes vagues du large, la baie trop ouverte, au bord de laquelle s’est élevée la nouvelle ville. </p>
        <p> Mais ce port artificiel paraît avoir été abandonné, au moins par les steamers de la compagnie du Pacifique, et c’est maintenant Fort-William qui est devenu le terminus de la navigation des lacs. </p>
        <p> C’est donc ici, aux quais de Port-Arthur, que les voyageurs qui avaient suivi la route des lacs, venaient, en 1889, rejoindre les trains du Pacifique en destination de l’Ouest. </p>
        <p> Cette route des grands lacs est sans contredit la plus variée, la plus intéressante et en même temps la plus agréable — quand il fait beau. </p>
        <p> Je n’ai pas oublié pour ma part le charmant voyage que j’ai fait en 1889, de Montréal à Port-Arthur, par la route des Lacs, et je demande la permission de reproduire ici les impressions que j’ai notées et publiées alors dans les journaux. </p>
        <p> Mon récit de voyage en deviendra plus complet puisqu’il fera connaître à la fois les deux routes, par le chemin de fer et par les Lacs. </p>'];

        $postTable[5] = ['id' => 5, 'title' => 'V LES BOURGEOIS DU NORD-OUEST', 'text' => '<p> La route des lacs que nous venons de décrire était autrefois la seule suivie, avec cette différence qu’au lieu de remonter le fleuve Saint-Laurent, on avait généralement adopté une ligne plus courte pour atteindre le lac Huron. C’était la ligne que suit aujourd’hui le chemin de fer du Pacifique jusqu’au lac Nipissing — c’est-à-dire, qu’on remontait la rivière des Outaouais jusqu’à Mattawa ; de là on se dirigeait vers le lac Nipissing par les petites rivières et les lacs que j’ai indiqués déjà, et après avoir parcouru le lac Nipissing dans toute sa longueur, on rejoignait le lac Huron par la rivière des Français. De la baie Georgienne jusqu’au fond du lac Supérieur, à Fort-William, la navigation ne rencontrait plus d’autre interruption que le sault Sainte-Marie. </p>
        <p> Il va sans dire que ce long trajet de Montréal à Fort-William se faisait en canot d’écorce, et nécessitait de nombreux et difficiles portages. Le voyage durait généralement six semaines. </p>'];

        $postTable[6] = ['id' => 6, 'title' => 'VI LES PREMIERS MISSIONNAIRES', 'text' => '<p> La marche de la civilisation depuis l’avènement du christianisme est presque partout la même. Les découvreurs s’avancent les premiers, et révèlent au monde l’existence de terres et de races jusqu’alors inconnues. </p>
        <p> Les missionnaires catholiques s’élancent à leur suite, et ils ouvrent au milieu des solitudes sauvages les routes que suivront plus tard les colons. </p>
        <p> Nous avons vu comment les découvreurs français remontant notre grand fleuve et nos grands lacs étaient parvenus jusqu’à la région des prairies, et comment M. de la Vérandrye avait, de 1731 à 1748, établi des forts à différents endroits jusqu’aux rivages de la Saskatchewan. </p>
        <p> Nous avons vu comment les Bourgeois, qui étaient aussi des découvreurs, avaient étendu le champ de leurs opérations, et avaient poussé leurs expéditions jusqu’à l’Océan Pacifique. </p>
        <p> Le jour des missionnaires était alors venu ; car jusque là les Jésuites n’avaient guère pénétré au delà du Sault-Sainte-Marie. </p>'];
        
        if ($id === null) {
            $data = $postTable;
        } elseif ($id !== null && array_key_exists($id, $postTable)) {
            $data = $postTable[$id];
        }

        return $data;
    }
    
    public function showAll(): ?array
    {
        // renvoie tous les posts
        return $this->executeSqlDB();
    }

    public function showOne(int $id): ?array
    {
        return $this->executeSqlDB($id);
    }
}
