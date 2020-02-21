<?php
$current_url = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
$menus = [
    'Dashboard' => [
        'to' => 'dashboard.php',
        'icon' => 'fa fa-tachometer'
    ],
    'Send SMS' => [
        'icon' => 'fa fa-users',
        'can' => $_SESSION['user_role'] == 1,
        'childs' => [
            'Students Listing' => [
                'to' => 'students-sms-listing.php'
            ],
            'Add Students' => [
                'to' => 'add-students-sms-number.php'
            ],
            'Send SMS' => [
                'to' => 'send-sms-students.php'
            ]
        ]
    ],
    'Upload CSV' => [
        'icon' => 'fa fa-files-o',
        'can' => $_SESSION['user_role'] == 1,
        'childs' => [
            'Upload Student CSV' => [
                'to' => 'upload-student-csv.php'
            ]
        ]
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
            'All Students' => [
                'to' => 'all-students.php',
                'related' => ['student-profile.php']
            ],
            'Add Student' => [
                'to' => 'add-student.php'
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
    'Exam Management' => [
        'icon' => 'fa fa-graduation-cap',
        'can' => $_SESSION['user_role'] == 1,
        'childs' => [
            'Add Exam Type' => [
                'to' => 'exam-types-lists.php',
                'related' => ['add-exam-type.php']
            ],
            'Manage Exam Term' => [
                'to' => 'manage-exam-terms-lists.php',
                'related' => ['add-exam-term.php']
            ],
            'Exams List' => [
                'to' => 'exams-list.php',
                'related' => ['add-exams.php']
            ]
        ]
    ],
    'Leave Management' => [
        'icon' => 'fa fa-bullhorn',
        'can' => $_SESSION['user_role'] == 1,
        'childs' => [
            'Add Leaves Types' => [
                'to' => 'leaves-types.php',
                'related' => ['add-leaves-type.php']
            ],
            'Leave Requests List' => [
                'to' => 'leave-requests-list.php',
                'related' => ['view-leave-requests.php']
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
    'All Students List' => [
        'to' => 'all-students.php',
        'icon' => 'fa fa-users',
        'can' => $_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 3,
        'related' => ['student-profile.php']
    ],
    'Request Leave List' => [
        'to' => 'request-leave-list.php',
        'icon' => 'fa fa-bullhorn',
        'can' => $_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 3,
        'related' => ['add-leaves-type.php']
    ],
    'Student Attendance' => [
        'to' => 'student-attendance-list.php',
        'icon' => 'fa fa-address-card-o',
        'can' => $_SESSION['user_role'] == 2,
        'related' => ['student-attendance.php']
    ],
    'Exam Management' => [
        'icon' => 'fa fa-user',
        'can' => $_SESSION['user_role'] == 2,
        'childs' => [
            'Add Student Marks' => [
                'to' => 'students-exam-list.php',
                'related' => ['students-exam-list.php']
            ]
            // 'Add Student Marks' => [
            //     'to' => 'select-exam-list.php',
            //     'related' => ['student-attendance.php']
            // ],
            // 'Results & Analysis' => [
            //     'to' => 'add-students-marks.php',
            //     'related' => ['students-result.php']
            // ]
        ]
    ],
    'Attend. Management' => [
        'icon' => 'fa fa-user',
        'can' => $_SESSION['user_role'] == 1,
        'childs' => [
            'Student\'s Attendance' => [
                'to' => 'all-students-attendance-list.php'
            ],
            'Teacher\'s Attendance' => [
                'to' => 'teacher-attendance-list.php'
            ]
        ]
    ],
    'My Attendance' => [
        'to' => 'teacher-attendance-list.php',
        'icon' => 'fa fa-address-card-o',
        'can' => $_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 3
    ],
    ($_SESSION['user_role'] == 1 ? 'Teachers' : 'My') . ' Login Record' => [
        'to' => 'teacher-login-records-list.php',
        'icon' => 'fa fa-files-o'
    ],
    'Contacts' => [
        'to' => 'contacts.php',
        'icon' => 'fa fa-address-book'
    ],
    'Role and Permission' => [
        'icon' => 'fa fa-shield',
        'can' => $_SESSION['user_role'] == 1,
        'childs' => [
            'Roles' => [
                'to' => 'roles-list.php',
                'related' => ['add-roles.php']
            ],
            'Permission' => [
                'to' => 'permissions-list.php'
            ],
            'Users' => [
                'to' => 'users-list.php',
                'related' => ['edit-users.php']
            ],
            'Teachers' => [
                'to' => 'teachers.php',
                'related' => ['assign-teacher.php']
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
            'Admission Fee' => [
                'to' => 'admission-fee.php',
                'related' => ['add-edit-admission-fee.php', 'collect-admission-fee.php']
            ],
            'Monthly Fee' => [
                'to' => 'monthly-fee.php',
                'related' => ['add-edit-monthly-fee.php', 'collect-monthly-fee.php']
            ]
        ]
    ],
    'Payroll' => [
        'icon' => 'fa fa-money',
        'can' => $_SESSION['user_role'] == 1,
        'childs' => [
            'Employee Salary' => [
                'to' => 'employee-salary.php',
                'related' => ['view-employee-salary.php', 'add-employee-salary.php']
            ]
        ]
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
        });
        if (count($menu['childs'])) return $menu;
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
