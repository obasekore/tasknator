<?php
/**
 * PHPMaker 2024 User Level Settings
 */
namespace PHPMaker2024\taskinator_project_file;

/**
 * User levels
 *
 * @var array<int, string>
 * [0] int User level ID
 * [1] string User level name
 */
$USER_LEVELS = [["-2","Anonymous"],
    ["0","Default"],
    ["1","Client"],
    ["2","Tasker"]];

/**
 * User level permissions
 *
 * @var array<string, int, int>
 * [0] string Project ID + Table name
 * [1] int User level ID
 * [2] int Permissions
 */
$USER_LEVEL_PRIVS = [["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}Services","-2","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}Services","0","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}Services","1","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}Services","2","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}Tasks","-2","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}Tasks","0","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}Tasks","1","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}Tasks","2","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}Users","-2","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}Users","0","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}Users","1","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}Users","2","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}UserLevelPermissions","-2","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}UserLevelPermissions","0","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}UserLevelPermissions","1","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}UserLevelPermissions","2","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}UserLevels","-2","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}UserLevels","0","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}UserLevels","1","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}UserLevels","2","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}TaskerService","-2","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}TaskerService","0","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}TaskerService","1","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}TaskerService","2","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}ReviewsAndRatings","-2","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}ReviewsAndRatings","0","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}ReviewsAndRatings","1","0"],
    ["{FD897DF6-0387-4406-A2D6-F45FB6E3185A}ReviewsAndRatings","2","0"]];

/**
 * Tables
 *
 * @var array<string, string, string, bool, string>
 * [0] string Table name
 * [1] string Table variable name
 * [2] string Table caption
 * [3] bool Allowed for update (for userpriv.php)
 * [4] string Project ID
 * [5] string URL (for OthersController::index)
 */
$USER_LEVEL_TABLES = [["Services","Services","Services",true,"{FD897DF6-0387-4406-A2D6-F45FB6E3185A}","ServicesList"],
    ["Tasks","Tasks","Tasks",true,"{FD897DF6-0387-4406-A2D6-F45FB6E3185A}","TasksList"],
    ["Users","Users","",true,"{FD897DF6-0387-4406-A2D6-F45FB6E3185A}","UsersList"],
    ["UserLevelPermissions","UserLevelPermissions","User Level Permissions",true,"{FD897DF6-0387-4406-A2D6-F45FB6E3185A}","UserLevelPermissionsList"],
    ["UserLevels","UserLevels","User Levels",true,"{FD897DF6-0387-4406-A2D6-F45FB6E3185A}","UserLevelsList"],
    ["TaskerService","TaskerService","Tasker Service",true,"{FD897DF6-0387-4406-A2D6-F45FB6E3185A}","TaskerServiceList"],
    ["ReviewsAndRatings","ReviewsAndRatings","Reviews And Ratings",true,"{FD897DF6-0387-4406-A2D6-F45FB6E3185A}","ReviewsAndRatingsList"]];
