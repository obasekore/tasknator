<?php

namespace PHPMaker2024\taskinator_project_file;

// Navbar menu
$topMenu = new Menu("navbar", true, true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(3, "mi_Services", $Language->menuPhrase("3", "MenuText"), "ServicesList", -1, "", AllowListMenu('{FD897DF6-0387-4406-A2D6-F45FB6E3185A}Services'), false, false, "", "", false, true);
$sideMenu->addMenuItem(4, "mi_Tasks", $Language->menuPhrase("4", "MenuText"), "TasksList", -1, "", AllowListMenu('{FD897DF6-0387-4406-A2D6-F45FB6E3185A}Tasks'), false, false, "", "", false, true);
$sideMenu->addMenuItem(6, "mi_Users", $Language->menuPhrase("6", "MenuText"), "UsersList", -1, "", AllowListMenu('{FD897DF6-0387-4406-A2D6-F45FB6E3185A}Users'), false, false, "", "", false, true);
$sideMenu->addMenuItem(7, "mi_UserLevelPermissions", $Language->menuPhrase("7", "MenuText"), "UserLevelPermissionsList", -1, "", AllowListMenu('{FD897DF6-0387-4406-A2D6-F45FB6E3185A}UserLevelPermissions'), false, false, "", "", false, true);
$sideMenu->addMenuItem(8, "mi_UserLevels", $Language->menuPhrase("8", "MenuText"), "UserLevelsList", -1, "", AllowListMenu('{FD897DF6-0387-4406-A2D6-F45FB6E3185A}UserLevels'), false, false, "", "", false, true);
$sideMenu->addMenuItem(9, "mi_TaskerService", $Language->menuPhrase("9", "MenuText"), "TaskerServiceList", -1, "", AllowListMenu('{FD897DF6-0387-4406-A2D6-F45FB6E3185A}TaskerService'), false, false, "", "", false, true);
$sideMenu->addMenuItem(10, "mi_ReviewsAndRatings", $Language->menuPhrase("10", "MenuText"), "ReviewsAndRatingsList", -1, "", AllowListMenu('{FD897DF6-0387-4406-A2D6-F45FB6E3185A}ReviewsAndRatings'), false, false, "", "", false, true);
echo $sideMenu->toScript();
