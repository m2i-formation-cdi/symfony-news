<?php

namespace AppBundle\Services;

use DateTime;

class FakeDataProvider
{

    public function getName()
    {
        return 'FakeDataProvider';
    }

    public function getAllArticles()
    {
        $articles = array (
            array (
                'id' => 1,
                'title' => 'Angular-js 2 : un évolution attendue',
                'lead' => 'Primi igitur omnium statuuntur Epigonus et Eusebius ob nominum gentilitatem oppressi. praediximus enim Montium sub ipso vivendi termino his vocabulis appellatos fabricarum culpasse tribunos ut adminicula futurae molitioni pollicitos.',
                'createdAt' => new DateTime('-1 month'),
                'updatedAt' => new DateTime('-5 days'),
                'author' => array (
                    'id' => 1,
                    'fullName' => 'Fabrice Haski',
                    'name' => 'Haski',
                    'fisrtName' => 'Fabrice',
                    'email' => 'fhaski@mediapart.com',
                    'penName' => null,
                    'numberOfPosts' => 5
                ),
                'image' => array (
                    'fileName' => 'img01.jpg',
                    'legend' => 'une légende',
                    'credit' => 'Sébastien Maloron'
                ),
                'comments' => array('a', 'b', 'c')
            ),
            array (
                'id' => 2,
                'title' => 'PHP7 des performances accrues de 50%',
                'lead' => 'Primi igitur omnium statuuntur Epigonus et Eusebius ob nominum gentilitatem oppressi. praediximus enim Montium sub ipso vivendi termino his vocabulis appellatos fabricarum culpasse tribunos ut adminicula futurae molitioni pollicitos.',
                'createdAt' => new DateTime('-1 month'),
                'updatedAt' => new DateTime('-5 days'),
                'author' => array (
                    'id' => 1,
                    'fullName' => 'Fabrice Haski',
                    'name' => 'Haski',
                    'fisrtName' => 'Fabrice',
                    'email' => 'fhaski@mediapart.com',
                    'penName' => null,
                    'numberOfPosts' => 5
                ),
                'image' => array (
                    'fileName' => 'img02.jpg',
                    'legend' => 'une légende',
                    'credit' => 'Sébastien Maloron'
                ),
                'comments' => array('a', 'b', 'c','d')
            ),
            array (
                'id' => 3,
                'title' => 'Devops, la révolution en marche',
                'lead' => 'Primi igitur omnium statuuntur Epigonus et Eusebius ob nominum gentilitatem oppressi. praediximus enim Montium sub ipso vivendi termino his vocabulis appellatos fabricarum culpasse tribunos ut adminicula futurae molitioni pollicitos.',
                'createdAt' => new DateTime('-1 month'),
                'updatedAt' => new DateTime('-5 days'),
                'author' => array (
                    'id' => 1,
                    'fullName' => 'Fabrice Haski',
                    'name' => 'Haski',
                    'fisrtName' => 'Fabrice',
                    'email' => 'fhaski@mediapart.com',
                    'penName' => null,
                    'numberOfPosts' => 5
                ),
                'image' => array (
                    'fileName' => 'img03.jpg',
                    'legend' => 'une légende',
                    'credit' => 'Sébastien Maloron'
                ),
                'comments' => array('a', 'b', 'c', 'd', 'e')
            ),
            array (
                'id' => 4,
                'title' => 'Sensio Labs lève 5 millions d\'euros',
                'lead' => 'Primi igitur omnium statuuntur Epigonus et Eusebius ob nominum gentilitatem oppressi. praediximus enim Montium sub ipso vivendi termino his vocabulis appellatos fabricarum culpasse tribunos ut adminicula futurae molitioni pollicitos.',
                'createdAt' => new DateTime('-1 month'),
                'updatedAt' => new DateTime('-5 days'),
                'author' => array (
                    'id' => 2,
                    'fullName' => 'Paul Auster',
                    'name' => 'Auster',
                    'fisrtName' => 'Paul',
                    'email' => 'pauster@yahoo.com',
                    'penName' => null,
                    'numberOfPosts' => 3
                ),
                'image' => array (
                    'fileName' => 'img04.jpg',
                    'legend' => 'une légende',
                    'credit' => 'Sébastien Maloron'
                ),
                'comments' => array('a', 'b', 'c')
            )
        );

        return $articles;
    }

    public function getOneArticle()
    {
        $article = array (
            'id' => 1,
            'title' => 'Angular-js 2 : un évolution attendue',
            'lead' => 'Primi igitur omnium statuuntur Epigonus et Eusebius ob nominum gentilitatem oppressi. praediximus enim Montium sub ipso vivendi termino his vocabulis appellatos fabricarum culpasse tribunos ut adminicula futurae molitioni pollicitos.',
            'text' => 'Post hoc impie perpetratum quod in aliis quoque iam timebatur, tamquam licentia crudelitati indulta per suspicionum nebulas aestimati quidam noxii damnabantur. quorum pars necati, alii puniti bonorum multatione actique laribus suis extorres nullo sibi relicto praeter querelas et lacrimas, stipe conlaticia victitabant, et civili iustoque imperio ad voluntatem converso cruentam, claudebantur opulentae domus et clarae.

Haec igitur prima lex amicitiae sanciatur, ut ab amicis honesta petamus, amicorum causa honesta faciamus, ne exspectemus quidem, dum rogemur; studium semper adsit, cunctatio absit; consilium vero dare audeamus libere. Plurimum in amicitia amicorum bene suadentium valeat auctoritas, eaque et adhibeatur ad monendum non modo aperte sed etiam acriter, si res postulabit, et adhibitae pareatur.

Verum ad istam omnem orationem brevis est defensio. Nam quoad aetas M. Caeli dare potuit isti suspicioni locum, fuit primum ipsius pudore, deinde etiam patris diligentia disciplinaque munita. Qui ut huic virilem togam deditšnihil dicam hoc loco de me; tantum sit, quantum vos existimatis; hoc dicam, hunc a patre continuo ad me esse deductum; nemo hunc M. Caelium in illo aetatis flore vidit nisi aut cum patre aut mecum aut in M. Crassi castissima domo, cum artibus honestissimis erudiretur.',
            'tags' => array (
                array ('tagName' => 'angular'),
                array ('tagName' => 'javascript'),
                array ('tagName' => 'frontEnd')
            ),
            'createdAt' => new DateTime('-1 month'),
            'updatedAt' => new DateTime('-5 days'),
            'author' => array (
                'id' => 2,
                'fullName' => 'Paul Auster',
                'name' => 'Auster',
                'fisrtName' => 'Paul',
                'email' => 'pauster@yahoo.com',
                'penName' => null,
                'numberOfPosts' => 3
            ),
            'image' => array (
                'fileName' => 'img01.jpg',
                'legend' => 'une légende',
                'credit' => 'Sébastien Maloron'
            ),

            'comments' => array (
                array (
                    'author' => 'paul@yahoo.com',
                    'date' => new DateTime('-5 days'),
                    'text' => 'Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.'
                ),
                array (
                    'author' => 'alice@wanadoo.fr',
                    'date' => new DateTime('-16 days'),
                    'text' => 'Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.'
                ),

                array (
                    'author' => 'pierre@gnolu.com',
                    'date' => new DateTime('-20 days'),
                    'text' => 'Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.'
                )
            )
        );

        return $article;
    }

    public function getAllAuthors()
    {
        $authors = array (
            array (
                'id' => 1,
                'fullName' => 'Fabrice Haski',
                'name' => 'Haski',
                'fisrtName' => 'Fabrice',
                'email' => 'fhaski@mediapart.com',
                'penName' => null,
                'numberOfArticles' => 5
            ),
            array (
                'id' => 2,
                'fullName' => 'Paul Auster',
                'name' => 'Auster',
                'fisrtName' => 'Paul',
                'email' => 'pauster@yahoo.com',
                'penName' => null,
                'numberOfArticles' => 3
            ),

            array (
                'id' => 3,
                'fullName' => 'Emile Zola',
                'name' => 'Zola',
                'fisrtName' => 'Emile',
                'email' => 'jaccuse@yahoo.com',
                'penName' => null,
                'numberOfArticles' => 3
            ),
            array (
                'id' => 2,
                'fullName' => 'Joseph Pulitzer',
                'name' => 'Pulitzer',
                'fisrtName' => 'Joseph',
                'email' => 'jpulitzer@gmail.com',
                'penName' => null,
                'numberOfArticles' => 3
            )
        );

        return $authors;
    }

    public function getOneAuthor()
    {
        $author = array (
            'fullName' => 'Fabrice Haski',
            'name' => 'Haski',
            'fisrtName' => 'Fabrice',
            'email' => 'fhaski@mediapart.com',
            'penName' => null,
        );

        return $author;
    }

    public function getTags(){
        $tags = array(
            array('tagName' => 'PHP', 'numberOfArticles' => 15),
            array('tagName' => 'Symfony', 'numberOfArticles' => 8),
            array('tagName' => 'Javascript', 'numberOfArticles' => 4),
            array('tagName' => 'Angular', 'numberOfArticles' => 5),
            array('tagName' => 'Java', 'numberOfArticles' => 5),
        );

        return $tags;
    }

    public function getArchive(){
        $archive = array(
            array('year' => '2016', 'numberOfArticles' => 5),
            array('year' => '2015', 'numberOfArticles' => 10),
            array('year' => '2014', 'numberOfArticles' => 12),
            array('year' => '2013', 'numberOfArticles' => 8),
        );

        return $archive;
    }

    public function getAllComments(){
        $comments = array(
            array (
                'author' => 'paul@yahoo.com',
                'date' => new DateTime('-5 days'),
                'text' => 'Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.'
            ),
            array (
                'author' => 'alice@wanadoo.fr',
                'date' => new DateTime('-16 days'),
                'text' => 'Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.'
            ),

            array (
                'author' => 'pierre@gnolu.com',
                'date' => new DateTime('-20 days'),
                'text' => 'Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.'
            )
        );

        return $comments;
    }
}