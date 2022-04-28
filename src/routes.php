<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    '' => ['HomeController', 'index',],
    'products' => ['ProductController', 'index',],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
    'items/delete' => ['ItemController', 'delete',],
    'admin/cloth' => ['AdminClothController', 'index',],
    'admin/cloth/add' => ['AdminClothController', 'addCloth' ],
    'admin/cloth/edit' => ['AdminClothController', 'editCloth', ['id']],
    'admin/cloth/delete' => ['AdminClothController', 'deleteCloth', ],
    'admin/machine' => ['AdminMachineController', 'index',],
    'admin/machine/add' => ['AdminMachineController', 'addMachine',],
];
