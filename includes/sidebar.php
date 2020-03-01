<?php
$current_url = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
$menus = [
    'Dashboard' => [
        'to' => 'dashboard.php',
        'icon' => 'fa fa-tachometer'
    ],
    'Teachers Listing' => [
        'icon' => 'fa fa-users',
        'can' => $_SESSION['user_role'] == 1,
        'childs' => [
            'All Teachers' => [
                'to' => 'all-teachers.php',
                'related' => ['teacher-profile.php']
            ],
            'Add Teacher' => [
                'to' => 'add-teacher.php'
            ]
        ]
    ],
    'Students Listing' => [
        'icon' => 'fa fa-users',
        'can' => $_SESSION['user_role'] == 1,
        'childs' => [
            'Add Student' => [
                'to' => 'add-student.php'
            ],
            'Upload Student CSV' => [
                'to' => 'upload-student-csv.php'
            ],
            'Search Students' => [
                'to' => 'all-students.php',
                'related' => ['student-profile.php']
            ]
        ]    
    ],
    'Classes & Sections' => [
        'icon' => 'fa fa-building',
        'can' => $_SESSION['user_role'] == 1,
        'childs' => [
            'Classes List' => [
                'to' => 'class-section-list.php'
            ],
            'Add Classes' => [
                'to' => 'class-section.php'
            ]
        ]
    ],
    'Subjects' => [
        'icon' => 'fa fa-book',
        'can' => $_SESSION['user_role'] == 1,
        'childs' => [
            'Subjects List' => [
                'to' => 'subject-lists.php'
            ],
            'Add Subjects' => [
                'to' => 'add-subjects.php'
            ]
        ]
    ],
    'Holidays / Events' => [
        'icon' => 'fa fa-calendar',
        'childs' => [
            'Calender' => [
                'to' => 'calender.php'
            ],
            'Holidays' => [
                'to' => 'holidays.php'
            ],
            'Events' => [
                'to' => 'events.php'
            ]
        ]
    ],
    'HR' => [
        'icon' => 'fa fa-table',
        'can' => $_SESSION['user_role'] == 1,
        'childs' => [
            'Admission Form' => [
                'to' => 'admission-form-listing.php',
                'related' => ['add-admission-form.php']
            ],
            'TC Form' => [
                'to' => 'transfer-certificate-listing.php',
                'related' => ['add-transfer-certificate.php']
            ]
        ]
    ],
    'Accounts' => [
        'icon' => 'fa fa-money',
        'can' => $_SESSION['user_role'] == 1,
        'childs' => [
            'Fees Head' => [
                'to' => 'fee-head.php',
                'related' => ['add-edit-fee-head.php']
            ],
            'Discounts' => [
                'to' => 'discount.php',
                'related' => ['monthly-discount.php']
            ],
            'Admission Fee List' => [
                'to' => 'admission-fee.php',
                'related' => ['add-edit-admission-fee.php', 'collect-admission-fee.php']
            ],
            'Monthly Fee List' => [
                'to' => 'monthly-fee.php',
                'related' => ['add-edit-monthly-fee.php', 'collect-monthly-fee.php']
            ]
        ]
    ],
    'Admission Fee List' => [
        'icon' => 'fa fa-money',
        'can' => $_SESSION['user_role'] == 4,
        'to' => 'admission-fee-list.php'
    ],
    'Monthly Fee List' => [
        'icon' => 'fa fa-money',
        'can' => $_SESSION['user_role'] == 4,
        'to' => 'monthly-fee-list.php'
    ],
    'Expenses' => [
        'icon' => 'fa fa-money',
        'can' => $_SESSION['user_role'] == 1,
        'childs' => [
            'Expense Types' => [
                'to' => 'expense-types-list.php',
                'related' => ['add-expense-types.php']
            ],
            'Expenses List' => [
                'to' => 'expenses-list.php',
                'related' => ['add-expenses.php']
            ]
        ]
    ],
    'My Pay Slip' => [
        'to' => 'view-employee-salary.php',
        'icon' => 'fa fa-money',
        'can' => $_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 3
    ],
    'Gallery' => [
        'to' => 'gallery.php',
        'icon' => 'fa fa-picture-o'
    ]
];

$menus = array_filter($menus, function ($menu) {
    if (isset($menu['can']) && false === $menu['can']) return;
    if (isset($menu['childs'])) {
        $menu['childs'] = array_filter($menu['childs'], function ($child) {
            if (isset($child['can']) && false === $child['can']) return;

            if (user_has_permission($child['to'])) return $child;
            return;
        });

        if (count($menu['childs'])) return $menu;
        return;
    }
    if (user_has_permission($menu['to'])) return $menu;
});

$menus =  array_map(function ($menu) {
    if (!isset($menu['to'])) $menu['to'] = '#';
    if (!isset($menu['childs'])) $menu['childs'] = [];
    if (!isset($menu['related'])) $menu['related'] = [];
    if ($menu['to'] != '#') array_push($menu['related'], $menu['to']);

    $menu['childs'] = array_map(function ($child) {
        if (!isset($child['related'])) $child['related'] = [];

        if ($child['to'] != '#') array_push($child['related'], $child['to']);
        return $child;
    }, $menu['childs']);

    return $menu;
}, $menus);
?>

<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">Main</li>
                <?php foreach ($menus as $text => $menu) : ?>
                    <?php
                    $class_names = [];
                    if (count($menu['childs'])) array_push($class_names, 'submenu');
                    if (in_array($current_url, $menu['related'])) array_push($class_names, 'active');
                    ?>
                    <li class="<?= implode(', ', $class_names); ?>">
                        <a href="<?= $menu['to']; ?>">
                            <i class="<?= $menu['icon']; ?>" aria-hidden="true"></i>
                            <span><?= $text; ?></span>
                            <?php if (count($menu['childs'])) : ?>
                                <span class="menu-arrow"></span>
                            <?php endif; ?>
                        </a>
                        <?php if (count($menu['childs'])) : ?>
                            <ul class="list-unstyled" style="display: none;">
                                <?php foreach ($menu['childs'] as $child_text => $child) : ?>
                                    <li><a class="<?= in_array($current_url, $child['related']) ? 'active' : ''; ?>" href="<?= $child['to']; ?>"><?= $child_text; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
