const TASKM_LANG_ZH = 'zh-CN';
const TASKM_LANG_EN = 'en';
const TASKM_TIME_ZONE = 'Asia/Shanghai';

const TASKM_TRANSLATIONS = {
    'zh-CN': {
        common: {
            brand: 'TaskM',
            allTasks: '全部任务',
            myDay: '我的一天',
            logout: '退出',
            loading: '加载中...',
            loadingTasks: '正在加载任务',
            preparingToday: '正在准备今日任务',
            loadingDetail: '正在加载详情',
            loadingPleaseWait: '请稍候。',
            loadFailed: '加载失败',
            refreshAndRetry: '请刷新后重试。',
            networkRetry: '网络错误，请重试',
            backToDashboard: '返回主页',
            taskStatusCompleted: '已完成',
            overallProgress: '整体进度',
            currentProgress: '当前进度',
            progressValue: '进度：{progress}%',
            itemCount: '{count} 个',
            recordCount: '共 {count} 条记录。',
            noCommitYet: '暂无提交记录',
            todayProgressWillAppearHere: '今天的进度会显示在这里。',
            uncategorized: '未分类',
            today: '今天',
            tomorrow: '明天',
            dueToday: '今天到期',
            dueTomorrow: '明天到期',
            dueInDays: '{count} 天后到期',
            overdueDays: '逾期 {count} 天',
            alreadyOverdue: '已逾期',
            idleDays: '{count} 天未更新',
            pendingRecord: '待补记录',
            noOverdueTasks: '没有逾期任务',
            noTasksNeedRecords: '暂无需要补记录的任务',
            noRecentPriority: '还没有明确优先级，先创建一个任务开始推进。',
            loginPage: '/pages/login.html',
            dashboardPage: '/pages/dashboard.html'
        },
        auth: {
            loginTitle: '登录',
            registerTitle: '注册',
            account: '用户名 / 邮箱',
            username: '用户名',
            email: '邮箱',
            password: '密码',
            passwordMin: '密码（至少 6 位）',
            confirmPassword: '确认密码',
            loginSubmit: '登录',
            registerSubmit: '注册',
            registerSubmitting: '注册中...',
            createSubmitting: '创建中...',
            createSubmit: '创建',
            incomplete: '请填写完整信息',
            loginFailed: '登录失败',
            loginRetry: '登录失败，请重试',
            registerFailed: '注册失败',
            registerRetry: '注册失败，请重试',
            usernameMin: '用户名至少需要 2 个字符',
            passwordMinError: '密码至少需要 6 位',
            passwordMismatch: '两次密码输入不一致',
            noAccount: '还没有账号？',
            goRegister: '立即注册',
            hasAccount: '已有账号？',
            goLogin: '立即登录'
        },
        commits: {
            no_progress: '无进展',
            completed: '已完成',
            follow_up: '进度跟进',
            noProgressToast: '已记录今日无进展',
            completedToast: '已标记完成',
            followUpToast: '跟进已提交',
            submitFailed: '提交失败',
            submitted: '已提交'
        },
        dashboard: {
            title: '主页',
            heroTodayView: '今日视图',
            heroGreeting: '你好，{name}',
            urgentLabel: '最急着处理',
            stalledLabel: '需要补记录',
            syncing: '同步中',
            overdueAnalyzing: '正在分析逾期与临近截止的任务。',
            recordAnalyzing: '正在查找久未更新或长期停滞的任务。',
            nextStep: '下一步',
            heroCaptionDefault: '正在整理最值得先处理的任务。',
            openMyDay: '打开我的一天',
            taskList: '任务列表',
            taskListSubtitle: '保留最重要的信息，只显示真正需要看的内容。',
            guide: '新手指引',
            sortNewest: '最新',
            sortCategory: '类别',
            sortDdl: 'DDL',
            sortProgress: '进度',
            noTasks: '还没有任务',
            createFirstTask: '先建一个，再开始推进。',
            completedTasks: '已完成任务',
            revertTask: '返回未完成',
            taskCreated: '任务已创建',
            taskReverted: '任务已返回未完成状态',
            createTask: '新建任务',
            taskTitle: '任务标题',
            taskDescription: '任务描述',
            category: '类别',
            ddl: 'DDL',
            pickDatetime: '点击选择日期时间',
            tags: '标签',
            tagsPlaceholder: '用逗号分隔，如 工作,重要',
            cancel: '取消',
            create: '创建',
            titleRequired: '请填写任务标题',
            createFailed: '创建失败',
            summaryZero: '还没有任务，点右下角开始创建。',
            summaryTemplate: '共 {total} 个任务，{active} 个在推进，{completed} 个已完成。',
            summaryOverdue: '{count} 个已逾期',
            summaryDueToday: '{count} 个今天到期',
            summaryNeedRecords: '{count} 个缺少最近记录',
            focusOverdue: '先把已经超时的任务收口，避免列表继续失真。',
            focusToday: '今天还有 {count} 个任务会到点，建议尽快处理。',
            focusStable: '当前没有逾期任务，节奏还算稳。',
            stalledHasItems: '这些任务缺少最近记录，先补状态，再决定要不要继续推进。',
            stalledFocusTasks: '如果没有需要补记录的任务，可以从这些可推进任务开始。',
            stalledNone: '最近都有更新记录，不需要额外补日志。',
            heroOverdue: '优先处理「{title}」，已经逾期，先决定继续推进还是调整截止时间。',
            heroWithDeadline: '下一项关键节点是「{title}」，截止时间 {deadline}。',
            heroMissingRecord: '「{title}」最近缺少进展记录，建议先补一条当前状态。',
            sublineDdl: 'DDL {value}',
            sublineProgress: '进度 {value}%',
            emptyInsightOverdue: '没有逾期任务',
            emptyInsightRecord: '暂无需要补记录的任务'
        },
        myday: {
            title: '我的一天',
            emptyTitle: '今天没有待处理任务',
            emptyDesc: '你已经把当前任务都处理完了。',
            finishedTitle: '今日进展已记录完成',
            finishedDesc: '所有任务都已经处理到位。',
            noProgress: '今天没做',
            completed: '完成',
            followUp: '今天跟进',
            completedWhat: '完成了什么',
            completedPlaceholder: '记录完成了什么',
            followUpTitle: '今天的跟进记录',
            followUpPlaceholder: '记录今天对这个任务的进展、行动或思考',
            cancel: '取消',
            submitCompleted: '提交完成',
            submitFollowUp: '提交跟进'
        },
        detail: {
            title: '任务详情',
            missingTitle: '任务不存在',
            missingDesc: '请返回主页查看其他任务。',
            deleteConfirmTitle: '确认删除',
            deleteConfirmDesc: '删除后无法恢复，确定要删除这个任务吗？',
            deleteCancel: '取消',
            deleteConfirm: '确认删除',
            backToDashboard: '返回主页',
            deleteTask: '删除',
            history: '历史记录',
            todayRecord: '今日记录',
            todayRecordDesc: '完成或跟进后，历史会自动更新。',
            hasRecordToday: '今天已有记录，继续添加更多吧',
            noRecordToday: '今天还没有记录，快来添加第一条吧',
            completedPlaceholder: '记录你完成了什么',
            followUpPlaceholder: '记录今天的进展、行动或思考',
            submitCompleted: '提交完成',
            submitFollowUp: '提交跟进',
            deleteSuccess: '任务已删除',
            deleteFailed: '删除失败'
        },
        onboarding: {
            title: '新手指引',
            prev: '上一页',
            next: '下一页',
            start: '开始吧',
            progress: '第 {current} 页 / {total} 页',
            steps: [
                {
                    title: '欢迎来到 TaskM！\n先点做准备吧',
                    desc: 'TaskM 不是一张越用越乱的长清单。\n它更像一个用来理顺优先级、推进任务、保留记录的工作台。',
                    note: '先看几页简短说明，再开始使用。',
                    visual: {
                        type: 'image',
                        src: '/assets/pic/login.jpg',
                        alt: 'TaskM 登录页面',
                        caption: '先进入账号，再开始后面的任务整理和推进。'
                    }
                },
                {
                    title: '我们不是{{催命的}}清单',
                    desc: '很多任务工具的问题不是功能不够，而是信息太满。\nTaskM 会把真正需要关注的任务留在前面，把已经完成的内容折叠起来。',
                    note: '重点一直只有一个：少一点干扰，多一点推进。',
                    visual: {
                        type: 'text',
                        kicker: '设计理念',
                        title: '列表应该服务判断',
                        items: [
                            { title: '少翻找', desc: '进行中的任务留在上面，已完成任务统一收到底部。' },
                            { title: '少干扰', desc: '真正需要看的信息直接放在眼前，不让列表越滚越长。' },
                            { title: '少犹豫', desc: '看一眼就知道哪些任务该先处理。' }
                        ]
                    }
                },
                {
                    title: '先看{{主页}}，',
                    desc: '主页是总览区。\n这里会看到任务列表、分类、DDL、进度和最近记录。\n\n决定先做什么之后，再进入按天处理页逐个推进。',
                    note: '主页负责看清全局和顺序。',
                    visual: {
                        type: 'image',
                        src: '/assets/pic/dashboard.jpg',
                        alt: 'TaskM 主页',
                        caption: '主页先负责看清：现在有哪些任务、谁更急、谁该先做。',
                        fallbackTitle: '主页会展示什么',
                        fallbackText: '图片加载完成前，先用文字看一眼核心信息。',
                        fallbackItems: [
                            '任务列表、分类、DDL 和最近记录。',
                            '优先级和当前最值得先处理的事情。'
                        ]
                    }
                },
                {
                    title: '「{{我的一天}}」',
                    desc: '「我的一天」是执行页。\n页面会一张一张带出待处理任务，每次只需要关注当前这一项。\n\n这里可以直接记录今天没做、今天跟进，或者完成。',
                    note: '按天处理页负责把动作真正落下来。',
                    visual: {
                        type: 'image',
                        src: '/assets/pic/myday.jpg',
                        alt: 'TaskM 我的一天页面',
                        caption: '一次只处理一个任务，提交后自然进入下一项。',
                        fallbackTitle: '这个页面会做什么',
                        fallbackText: '图片加载完成前，先看这个页面的核心节奏。',
                        fallbackItems: [
                            '每次只专注当前这一个任务。',
                            '直接记录没做、跟进或完成。'
                        ]
                    }
                },
                {
                    title: '{{真正常用的}}功能，其实就这几件事',
                    desc: '最常用的动作其实不多：创建任务、提交跟进、标记完成。\n当进度到 100% 时，任务会自动进入已完成折叠区。',
                    note: '如果后面还要继续，也可以重新返回未完成状态。',
                    visual: {
                        type: 'text',
                        kicker: '常用功能',
                        title: '只需要记住这三件事',
                        items: [
                            { title: '新建任务', desc: '把标题、背景、类别和 DDL 放清楚。' },
                            { title: '提交跟进', desc: '把今天的推进和进度记录下来。' },
                            { title: '完成归档', desc: '任务完成后自动折叠到底部，列表更干净。' }
                        ]
                    }
                },
                {
                    title: '类别和标签真的没有区别。\n{{随便用}}',
                    desc: '创建任务时填的类别和标签，本质上都是帮你分组和筛选。\n不用纠结该放哪边，按自己的习惯来就行。',
                    note: '',
                    visual: {
                        type: 'text',
                        kicker: '小提示',
                        title: '不必区分太细',
                        items: [
                            { title: '类别', desc: '比如 工作、学习、生活，用来粗分任务。' },
                            { title: '标签', desc: '比如 重要、紧急，用来打标记。混用也没关系。' }
                        ]
                    }
                },
                {
                    title: '轰！擦擦！\n你已学会如何使用 TaskM！开始吧！',
                    desc: '现在已经知道 TaskM 的用法了：\n先在主页看清全局，再进入按天处理页逐个推进，让每一次行动都留下记录。',
                    note: '点下面的按钮回到主页，开始建立你的第一批任务。',
                    visual: {
                        type: 'text',
                        kicker: '快速上手',
                        title: '回到主页后先做这三步',
                        items: [
                            { title: '先建任务', desc: '把标题、背景、类别和 DDL 先补清楚。' },
                            { title: '再看顺序', desc: '先从主页确认今天最该推进的那一项。' },
                            { title: '开始记录', desc: '进入「我的一天」，把没做、跟进或完成记下来。' }
                        ]
                    }
                }
            ]
        },
        login: {
            pageTitle: '登录',
            heroTitle: '回到你的<span>任务节奏</span>',
            heroCopy: '用更安静、更清晰的界面查看任务、记录进度，把每天真正完成的事情留下来。',
            point1: '集中查看任务、类别、DDL 和进度',
            point2: '按天推进，减少上下文切换',
            point3: '所有记录都直接保存到你的任务历史',
            formSubtitle: '输入账号后继续。'
        },
        register: {
            pageTitle: '注册',
            heroTitle: '建立你的<span>任务空间</span>',
            heroCopy: '注册后就可以开始管理任务、记录每日进度，并用更简洁的方式跟踪长期目标。',
            point1: '新建任务时支持类别、标签和 DDL',
            point2: '我的一天帮助你快速推进未完成事项',
            point3: '任务详情页可以保留完整提交历史',
            formSubtitle: '创建账号后立即开始使用。'
        }
    },
    en: {
        common: {
            brand: 'TaskM',
            allTasks: 'All Tasks',
            myDay: 'My Day',
            logout: 'Log Out',
            loading: 'Loading...',
            loadingTasks: 'Loading tasks',
            preparingToday: 'Preparing today\'s tasks',
            loadingDetail: 'Loading details',
            loadingPleaseWait: 'Please wait.',
            loadFailed: 'Load failed',
            refreshAndRetry: 'Refresh the page and try again.',
            networkRetry: 'Network error. Please try again.',
            backToDashboard: 'Back to dashboard',
            taskStatusCompleted: 'Completed',
            overallProgress: 'Overall progress',
            currentProgress: 'Current progress',
            progressValue: 'Progress: {progress}%',
            itemCount: '{count}',
            recordCount: '{count} records',
            noCommitYet: 'No updates yet',
            todayProgressWillAppearHere: 'Today\'s progress will appear here.',
            uncategorized: 'Uncategorized',
            today: 'Today',
            tomorrow: 'Tomorrow',
            dueToday: 'Due today',
            dueTomorrow: 'Due tomorrow',
            dueInDays: 'Due in {count} days',
            overdueDays: '{count} days overdue',
            alreadyOverdue: 'Overdue',
            idleDays: 'No update for {count} days',
            pendingRecord: 'Needs update',
            noOverdueTasks: 'No overdue tasks',
            noTasksNeedRecords: 'No tasks need updates',
            noRecentPriority: 'No clear priority yet. Create a task to get started.',
            loginPage: '/pages/login.html',
            dashboardPage: '/pages/dashboard.html'
        },
        auth: {
            loginTitle: 'Sign In',
            registerTitle: 'Sign Up',
            account: 'Username / Email',
            username: 'Username',
            email: 'Email',
            password: 'Password',
            passwordMin: 'Password (at least 6 characters)',
            confirmPassword: 'Confirm password',
            loginSubmit: 'Sign In',
            registerSubmit: 'Sign Up',
            registerSubmitting: 'Creating...',
            createSubmitting: 'Creating...',
            createSubmit: 'Create',
            incomplete: 'Please fill in all required fields.',
            loginFailed: 'Sign in failed',
            loginRetry: 'Sign in failed. Please try again.',
            registerFailed: 'Sign up failed',
            registerRetry: 'Sign up failed. Please try again.',
            usernameMin: 'Username must be at least 2 characters.',
            passwordMinError: 'Password must be at least 6 characters.',
            passwordMismatch: 'The passwords do not match.',
            noAccount: 'No account yet?',
            goRegister: 'Create one',
            hasAccount: 'Already have an account?',
            goLogin: 'Sign in now'
        },
        commits: {
            no_progress: 'No progress',
            completed: 'Completed',
            follow_up: 'Follow-up',
            noProgressToast: 'Marked as no progress today',
            completedToast: 'Marked as completed',
            followUpToast: 'Follow-up submitted',
            submitFailed: 'Submit failed',
            submitted: 'Submitted'
        },
        dashboard: {
            title: 'Dashboard',
            heroTodayView: 'Today',
            heroGreeting: 'Hi, {name}',
            urgentLabel: 'Needs attention first',
            stalledLabel: 'Needs updates',
            syncing: 'Syncing',
            overdueAnalyzing: 'Looking for overdue and upcoming tasks.',
            recordAnalyzing: 'Checking tasks with stale or missing updates.',
            nextStep: 'Next step',
            heroCaptionDefault: 'Sorting out the most valuable task to tackle next.',
            openMyDay: 'Open My Day',
            taskList: 'Tasks',
            taskListSubtitle: 'Keep only the information you actually need in view.',
            guide: 'Quick Guide',
            sortNewest: 'Newest',
            sortCategory: 'Category',
            sortDdl: 'Deadline',
            sortProgress: 'Progress',
            noTasks: 'No tasks yet',
            createFirstTask: 'Create one to get things moving.',
            completedTasks: 'Completed tasks',
            revertTask: 'Move back to active',
            taskCreated: 'Task created',
            taskReverted: 'Task moved back to active',
            createTask: 'New Task',
            taskTitle: 'Task title',
            taskDescription: 'Task description',
            category: 'Category',
            ddl: 'Deadline',
            pickDatetime: 'Pick a date and time',
            tags: 'Tags',
            tagsPlaceholder: 'Separate with commas, e.g. work,important',
            cancel: 'Cancel',
            create: 'Create',
            titleRequired: 'Please enter a task title.',
            createFailed: 'Create failed',
            summaryZero: 'No tasks yet. Use the button in the lower-right corner to create one.',
            summaryTemplate: '{total} tasks total, {active} active, {completed} completed.',
            summaryOverdue: '{count} overdue',
            summaryDueToday: '{count} due today',
            summaryNeedRecords: '{count} missing recent updates',
            focusOverdue: 'Close out overdue tasks first so the list stays honest.',
            focusToday: '{count} task(s) are due today. It\'s a good time to handle them now.',
            focusStable: 'Nothing is overdue right now. The pace looks stable.',
            stalledHasItems: 'These tasks are missing recent updates. Add a status first, then decide what to do next.',
            stalledFocusTasks: 'If nothing needs a status update, start with one of these movable tasks.',
            stalledNone: 'Everything has been updated recently.',
            heroOverdue: 'Handle "{title}" first. It is overdue, so decide whether to continue or adjust the deadline.',
            heroWithDeadline: 'The next key task is "{title}", due at {deadline}.',
            heroMissingRecord: '"{title}" has no recent progress update. Add a quick status first.',
            sublineDdl: 'Deadline {value}',
            sublineProgress: 'Progress {value}%',
            emptyInsightOverdue: 'No overdue tasks',
            emptyInsightRecord: 'Nothing needs a status update'
        },
        myday: {
            title: 'My Day',
            emptyTitle: 'No active tasks for today',
            emptyDesc: 'You have already handled everything that is currently active.',
            finishedTitle: 'Today\'s progress is fully recorded',
            finishedDesc: 'Every task in this session has been handled.',
            noProgress: 'No work today',
            completed: 'Done',
            followUp: 'Worked on it today',
            completedWhat: 'What did you finish?',
            completedPlaceholder: 'Write what you completed',
            followUpTitle: 'Today\'s follow-up',
            followUpPlaceholder: 'Write what you progressed, did, or thought about today',
            cancel: 'Cancel',
            submitCompleted: 'Submit completion',
            submitFollowUp: 'Submit follow-up'
        },
        detail: {
            title: 'Task Details',
            missingTitle: 'Task not found',
            missingDesc: 'Go back to the dashboard to view other tasks.',
            deleteConfirmTitle: 'Delete task?',
            deleteConfirmDesc: 'This action cannot be undone. Do you want to delete this task?',
            deleteCancel: 'Cancel',
            deleteConfirm: 'Delete',
            backToDashboard: 'Back to dashboard',
            deleteTask: 'Delete',
            history: 'History',
            todayRecord: 'Today\'s update',
            todayRecordDesc: 'History updates automatically after you complete or follow up.',
            hasRecordToday: 'There is already an update today. You can add another one.',
            noRecordToday: 'There is no update today yet. Add the first one now.',
            completedPlaceholder: 'Write what you completed',
            followUpPlaceholder: 'Write today\'s progress, actions, or thoughts',
            submitCompleted: 'Submit completion',
            submitFollowUp: 'Submit follow-up',
            deleteSuccess: 'Task deleted',
            deleteFailed: 'Delete failed'
        },
        onboarding: {
            title: 'Quick Guide',
            prev: 'Previous',
            next: 'Next',
            start: 'Get started',
            progress: 'Page {current} / {total}',
            steps: [
                {
                    title: 'Welcome to TaskM!\nLet\'s get ready first.',
                    desc: 'TaskM is not a task list that gets noisier the longer you use it.\nIt is a workspace for clarifying priorities, moving tasks forward, and keeping a useful record.',
                    note: 'Read a few short pages first, then start using it.',
                    visual: {
                        type: 'image',
                        src: '/assets/pic/login.jpg',
                        alt: 'TaskM sign-in page',
                        caption: 'Start by signing in, then move on to organizing and advancing your tasks.'
                    }
                },
                {
                    title: 'We are not a {{stressful}} checklist',
                    desc: 'The problem with many task tools is not a lack of features. It is too much information.\nTaskM keeps what matters in front and folds completed work away.',
                    note: 'There is only one focus: less noise, more progress.',
                    visual: {
                        type: 'text',
                        kicker: 'Design idea',
                        title: 'Lists should support decisions',
                        items: [
                            { title: 'Less digging', desc: 'Active tasks stay on top while completed tasks collapse to the bottom.' },
                            { title: 'Less noise', desc: 'What matters is visible right away so the list does not grow into chaos.' },
                            { title: 'Less hesitation', desc: 'A quick glance should tell you what to do first.' }
                        ]
                    }
                },
                {
                    title: 'Start from the {{dashboard}}',
                    desc: 'The dashboard is your overview.\nYou can see tasks, categories, deadlines, progress, and recent records there.\n\nOnce you know what to do next, move into the day-by-day flow.',
                    note: 'The dashboard is for clarity and ordering.',
                    visual: {
                        type: 'image',
                        src: '/assets/pic/dashboard.jpg',
                        alt: 'TaskM dashboard',
                        caption: 'The dashboard helps you see what exists, what is urgent, and what should come first.',
                        fallbackTitle: 'What the dashboard shows',
                        fallbackText: 'Before the image finishes loading, here is the core idea in text.',
                        fallbackItems: [
                            'Tasks, categories, deadlines, and recent updates.',
                            'Priority signals and what deserves attention first.'
                        ]
                    }
                },
                {
                    title: '{{My Day}} is where execution happens',
                    desc: '"My Day" is the execution view.\nTasks appear one by one so you only focus on the current one.\n\nYou can mark no progress, follow up, or completion right there.',
                    note: 'This page is for turning intent into action.',
                    visual: {
                        type: 'image',
                        src: '/assets/pic/myday.jpg',
                        alt: 'TaskM My Day page',
                        caption: 'Handle one task at a time, then naturally move to the next after submitting.',
                        fallbackTitle: 'What this page does',
                        fallbackText: 'Before the image finishes loading, here is the rhythm of this page.',
                        fallbackItems: [
                            'Focus on just one task at a time.',
                            'Record no progress, follow-up, or completion directly.'
                        ]
                    }
                },
                {
                    title: 'The {{core actions}} are actually simple',
                    desc: 'The most common actions are simple: create tasks, submit follow-ups, and mark completion.\nWhen progress reaches 100%, the task moves into the completed section automatically.',
                    note: 'If work resumes later, you can move it back to active.',
                    visual: {
                        type: 'text',
                        kicker: 'Core actions',
                        title: 'You only need to remember three things',
                        items: [
                            { title: 'Create tasks', desc: 'Make the title, background, category, and deadline clear.' },
                            { title: 'Submit follow-ups', desc: 'Record today\'s movement and progress.' },
                            { title: 'Archive by completing', desc: 'Completed tasks collapse to the bottom so the list stays cleaner.' }
                        ]
                    }
                },
                {
                    title: 'Categories and tags do not need strict rules.\n{{Use them freely}}',
                    desc: 'Both categories and tags simply help you group and filter tasks.\nDo not overthink which side to use. Follow whatever feels natural to you.',
                    note: '',
                    visual: {
                        type: 'text',
                        kicker: 'Tip',
                        title: 'No need to split hairs',
                        items: [
                            { title: 'Category', desc: 'For broad groups like work, study, or life.' },
                            { title: 'Tag', desc: 'For labels like important or urgent. Mixing them is fine too.' }
                        ]
                    }
                },
                {
                    title: 'That\'s it.\nYou already know how to use TaskM.',
                    desc: 'You now know the flow of TaskM:\nsee the big picture on the dashboard, then move through tasks one by one in My Day so every action leaves a record.',
                    note: 'Use the button below to go back to the dashboard and create your first batch of tasks.',
                    visual: {
                        type: 'text',
                        kicker: 'Quick start',
                        title: 'Do these three things first',
                        items: [
                            { title: 'Create tasks first', desc: 'Fill in the title, context, category, and deadline.' },
                            { title: 'Check the order', desc: 'Use the dashboard to confirm what matters most today.' },
                            { title: 'Start recording', desc: 'Go into My Day and log no progress, follow-up, or completion.' }
                        ]
                    }
                }
            ]
        },
        login: {
            pageTitle: 'Sign In',
            heroTitle: 'Get back to your<span>task rhythm</span>',
            heroCopy: 'View tasks and log progress in a calmer, clearer workspace so the work you actually finish each day stays visible.',
            point1: 'See tasks, categories, deadlines, and progress in one place',
            point2: 'Move day by day with less context switching',
            point3: 'Every update stays in your task history',
            formSubtitle: 'Enter your account to continue.'
        },
        register: {
            pageTitle: 'Sign Up',
            heroTitle: 'Build your<span>task space</span>',
            heroCopy: 'Create an account to start managing tasks, recording daily progress, and tracking long-term goals with less clutter.',
            point1: 'Add categories, tags, and deadlines when creating tasks',
            point2: 'Use My Day to move unfinished work forward quickly',
            point3: 'Keep a complete update history on each task detail page',
            formSubtitle: 'Create your account and start right away.'
        }
    }
};

function detectTaskMLanguage() {
    const sources = Array.isArray(navigator.languages) && navigator.languages.length
        ? navigator.languages
        : [navigator.language || TASKM_LANG_ZH];

    for (const lang of sources) {
        if (!lang) continue;
        const normalized = String(lang).toLowerCase();
        if (normalized.startsWith('en')) return TASKM_LANG_EN;
        if (normalized.startsWith('zh')) return TASKM_LANG_ZH;
    }
    return TASKM_LANG_ZH;
}

const TASKM_CURRENT_LANGUAGE = detectTaskMLanguage();
const TASKM_CURRENT_LOCALE = TASKM_CURRENT_LANGUAGE === TASKM_LANG_EN ? 'en-US' : TASKM_LANG_ZH;

if (document && document.documentElement) {
    document.documentElement.lang = TASKM_CURRENT_LANGUAGE;
}

function getCurrentLanguage() {
    return TASKM_CURRENT_LANGUAGE;
}

function isEnglish() {
    return TASKM_CURRENT_LANGUAGE === TASKM_LANG_EN;
}

function getTaskMDictionary() {
    return TASKM_TRANSLATIONS[TASKM_CURRENT_LANGUAGE] || TASKM_TRANSLATIONS[TASKM_LANG_ZH];
}

function getValueByPath(target, path) {
    if (!path) return undefined;
    return String(path).split('.').reduce((acc, part) => (
        acc && Object.prototype.hasOwnProperty.call(acc, part) ? acc[part] : undefined
    ), target);
}

function interpolateTaskM(template, params = {}) {
    return String(template).replace(/\{(\w+)\}/g, (_, key) => (
        Object.prototype.hasOwnProperty.call(params, key) ? String(params[key]) : `{${key}}`
    ));
}

function t(key, params = {}, fallback = '') {
    const value = getValueByPath(getTaskMDictionary(), key);
    if (typeof value === 'string') return interpolateTaskM(value, params);
    if (value !== undefined) return value;
    if (fallback) return interpolateTaskM(fallback, params);
    return key;
}

function pickLocalizedValue(values) {
    if (!values || typeof values !== 'object') return values;
    if (Object.prototype.hasOwnProperty.call(values, TASKM_CURRENT_LANGUAGE)) {
        return values[TASKM_CURRENT_LANGUAGE];
    }
    if (Object.prototype.hasOwnProperty.call(values, TASKM_LANG_ZH)) {
        return values[TASKM_LANG_ZH];
    }
    if (Object.prototype.hasOwnProperty.call(values, TASKM_LANG_EN)) {
        return values[TASKM_LANG_EN];
    }
    return values;
}

function setDocumentTitle(title) {
    document.title = `${title} - TaskM`;
}

function applyTranslation(el, attr, key) {
    if (!el || !key) return;
    const value = t(key);
    if (attr === 'html') {
        el.innerHTML = value;
        return;
    }
    if (attr === 'text') {
        el.textContent = value;
        return;
    }
    if (attr === 'placeholder' || attr === 'title' || attr === 'value' || attr === 'aria-label') {
        el.setAttribute(attr, value);
        if (attr === 'value') el.value = value;
    }
}

function translatePage(root = document) {
    root.querySelectorAll('[data-i18n]').forEach((el) => {
        applyTranslation(el, 'text', el.dataset.i18n);
    });
    root.querySelectorAll('[data-i18n-html]').forEach((el) => {
        applyTranslation(el, 'html', el.dataset.i18nHtml);
    });
    root.querySelectorAll('[data-i18n-placeholder]').forEach((el) => {
        applyTranslation(el, 'placeholder', el.dataset.i18nPlaceholder);
    });
    root.querySelectorAll('[data-i18n-title]').forEach((el) => {
        applyTranslation(el, 'title', el.dataset.i18nTitle);
    });
    root.querySelectorAll('[data-i18n-value]').forEach((el) => {
        applyTranslation(el, 'value', el.dataset.i18nValue);
    });
    root.querySelectorAll('[data-i18n-aria-label]').forEach((el) => {
        applyTranslation(el, 'aria-label', el.dataset.i18nAriaLabel);
    });
}

function getTaskMHeaders(extraHeaders = {}) {
    return {
        'Accept-Language': getCurrentLanguage(),
        'X-TaskM-Lang': getCurrentLanguage(),
        ...extraHeaders,
    };
}

// ── SHA-256 via Web Crypto API ──
async function sha256(message) {
    const msgBuffer = new TextEncoder().encode(message);
    const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    return hashArray.map((b) => b.toString(16).padStart(2, '0')).join('');
}

// ── Toast / Snackbar ──
function showToast(msg, duration = 3000) {
    let sb = document.getElementById('snackbar');
    if (!sb) {
        sb = document.createElement('div');
        sb.id = 'snackbar';
        document.body.appendChild(sb);
    }
    sb.textContent = msg;
    sb.className = 'show';
    setTimeout(() => {
        sb.className = '';
    }, duration);
}

// ── Fetch helpers ──
async function apiPost(url, data) {
    const res = await fetch(url, {
        method: 'POST',
        headers: getTaskMHeaders({ 'Content-Type': 'application/json' }),
        body: JSON.stringify(data),
    });
    return res.json();
}

async function apiGet(url) {
    const res = await fetch(url, {
        headers: getTaskMHeaders(),
    });
    return res.json();
}

// ── Format helpers ──
function formatDate(dateStr) {
    if (!dateStr) return '';
    const d = new Date(dateStr);
    return d.toLocaleDateString(TASKM_CURRENT_LOCALE, {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        timeZone: TASKM_TIME_ZONE,
    });
}

function formatDatetime(dateStr) {
    if (!dateStr) return '';
    const d = new Date(dateStr);
    return d.toLocaleString(TASKM_CURRENT_LOCALE, {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        timeZone: TASKM_TIME_ZONE,
    });
}

function commitTypeLabel(type) {
    return t(`commits.${type}`, {}, type);
}

function commitTypeIcon(type) {
    const map = { no_progress: 'sentiment_neutral', completed: 'check_circle', follow_up: 'trending_up' };
    return map[type] || 'circle';
}

function getCaptchaLanguage() {
    return isEnglish() ? 'en' : 'cn';
}

function getFlatpickrLocale() {
    return isEnglish() ? 'default' : 'zh';
}

// ── DDL color ──
function ddlClass(ddlStr) {
    if (!ddlStr) return '';
    const diff = new Date(ddlStr) - new Date();
    if (diff < 0) return 'color: var(--danger);';
    if (diff < 86400000 * 3) return 'color: var(--warning);';
    return '';
}

window.TaskM = {
    detectTaskMLanguage,
    getCurrentLanguage,
    isEnglish,
    t,
    pickLocalizedValue,
    translatePage,
    setDocumentTitle,
    getCaptchaLanguage,
    getFlatpickrLocale,
};
