<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    '' => ['HomeController', 'index',],
    'produits' => ['ProductController', 'index',],
    'tutoriels' => ['TutorialController', 'index',],
    'tutoriels/tutoriel' => ['TutorialController', 'show', ['id']],
    'tissus' => ['ClothController', 'index',],
    'tissus/categorie' => ['ClothController', 'showClothByCategory', ['id']],
    'machines' => ['MachineController', 'index',],
    'astuces' => ['TipsController', 'showTips'],
    'lexique' => ['LexiconController', 'index',],
    'astuces/trucs-et-astuces' => ['TipController', 'showTipById', ['id']],
    'contact' => ['ContactController', 'index', ['sent']],
    'admin/categories-tissus' => ['AdminClothCategoryController', 'index',],
    'admin/categories-tissus/ajouter' => ['AdminClothCategoryController', 'addClothCategory',],
    'admin/categories-tissus/supprimer' => ['AdminClothCategoryController', 'deleteClothCategory',],
    'admin/categories-tissus/editer' => ['AdminClothCategoryController', 'editClothCategory', ['id']],
    'admin/tissus' => ['AdminClothController', 'index',],
    'admin/tissus/ajouter' => ['AdminClothController', 'addCloth',],
    'admin/tissus/editer' => ['AdminClothController', 'editCloth', ['id']],
    'admin/tissus/supprimer' => ['AdminClothController', 'deleteCloth',],
    'admin/machines' => ['AdminMachineController', 'index',],
    'admin/machines/ajouter' => ['AdminMachineController', 'addMachine',],
    'admin/machines/editer' => ['AdminMachineController', 'editMachine', ['id']],
    'admin/machines/supprimer' => ['AdminMachineController', 'deleteMachine',],
    'admin/lexiques' => ['AdminLexiconController', 'index',],
    'admin/lexiques/ajouter' => ['AdminLexiconController', 'addLexicon'],
    'admin/lexiques/editer' => ['AdminLexiconController', 'editLexicon', ['id']],
    'admin/lexiques/supprimer' => ['AdminLexiconController', 'deleteLexicon'],
    'admin/astuces' => ['AdminTipController', 'index',],
    'admin/astuces/ajouter' => ['AdminTipController', 'addTip',],
    'admin/astuces/supprimer' => ['AdminTipController', 'deleteTip', ],
    'admin/tutoriels' => ['AdminTutorialController', 'index',],
];
