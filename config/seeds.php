<?php
require_once 'settings.php';
## Команда для запуска — php config/seeds.php
$envPath = dirname(__DIR__) . '/.env';
if (!file_exists($envPath)) die(".env  файл не найден по пути $envPath");
$env = parse_ini_file($envPath);
$requiredVars = ['DB_HOST', 'DB_USER', 'DB_PASS', 'DB_NAME'];
foreach ($requiredVars as $var) if (!isset($env[$var])) die("Переменная $var не задана в файле .env.");
$servername = $env['DB_HOST'];
$username = $env['DB_USER'];
$password = $env['DB_PASS'];
$dbname = $env['DB_NAME'];
$port = 3306;
$socket = "/Applications/MAMP/tmp/mysql/mysql.sock";

$conn = new mysqli($servername, $username, $password, '', $port, $socket);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
$sql = "DROP DATABASE IF EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "База данных '$dbname' удалена\n";
} else {
    die("Ошибка удаления БД: " . $conn->error);
}

## Создаем БД, если её нет
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "База данных '$dbname' создана или уже существует.\n";
} else {
    die("Ошибка создания БД: " . $conn->error);
}
$conn->select_db($dbname);

## Создание таблицы Pages
$sql = "CREATE TABLE IF NOT EXISTS Pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    link VARCHAR(255)
)";
NewTable($conn, $sql, 'Pages');

## Создание таблицы Articles
$sql = "CREATE TABLE IF NOT EXISTS Articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    author VARCHAR(255),
    description TEXT,
    images TEXT,
    video TEXT,
    pages_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pages_id) REFERENCES Pages(id) ON DELETE SET NULL
)";
NewTable($conn, $sql, 'Articles');

## Создание таблицы HomeArticles
$sql = "CREATE TABLE IF NOT EXISTS HomeArticles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    author VARCHAR(255),
    description TEXT,
    images TEXT,
    article_id INT,
    FOREIGN KEY (article_id) REFERENCES Articles(id) ON DELETE CASCADE
)";
NewTable($conn, $sql, 'HomeArticles');

## Создание таблицы Users
$sql = "CREATE TABLE IF NOT EXISTS Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
NewTable($conn, $sql, 'Users');

## Создание таблицы SavedArticles
$sql = "CREATE TABLE IF NOT EXISTS SavedArticles (
    user_id INT NOT NULL,
    article_id INT NOT NULL,
    saved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, article_id),
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (article_id) REFERENCES Articles(id) ON DELETE CASCADE
)";
NewTable($conn, $sql, 'SavedArticles');

## Вставляем данные админа в таблицу Users
$password_hash = password_hash('1q2w3e4r5t6y', PASSWORD_BCRYPT);
$sql_admin = "INSERT INTO Users (email, username, password_hash) VALUES ('admin@collaboration.com', 'admin', '$password_hash')";
if (!$conn->query($sql_admin)) {
    echo "Ошибка вставки админа в Users: " . $conn->error . "\n";
}

## Вставляем данные в таблицу pages
$pagesData = [
    ['Главная', 'Коллаборации изменившие мир моды', '/'],
    ['Искусство & мода', 'Мода и коллаборации: когда искусство встречает моду', '/articles/art_fashion'],
    ['Люкс и масс-маркет', 'Люкс и масс-маркет', '/articles/luxury_mass_market'],
    ['Поп-культура & мода', 'Мода и поп-культура', '/articles/pop_culture_fashion'],
    ['Статьи', NULL, '/articles'],
    ['Профиль', 'Профиль пользователя', '/user/profile'],
    ['Войти', 'Войдите в систему или создайте учётную запись', '/user/authorisation'],
    ['Регистрация', 'Войдите в систему или создайте учётную запись', '/user/registration']
];

foreach ($pagesData as $data) {
    $name = $conn->real_escape_string($data[0]);
    $description = $data[1] ? "'" . $conn->real_escape_string($data[1]) . "'" : "NULL";
    $pages_link = $data[2] ? "'" . $conn->real_escape_string($data[2]) . "'" : "NULL";

    $sql = "INSERT INTO Pages (name, description, link) 
            VALUES ('$name', $description, $pages_link)";

    if (!$conn->query($sql)) {
        echo "Ошибка вставки в pages: " . $conn->error . "\n";
    }
}

## Фотографии
$imageConfig = [
    'img_fashion_and_collaboration' => ['start' => 1, 'end' => 12, 'step' => 1, 'path' => 'fashion_and_collaboration', 'prefix' => 'fashion_and_collaboration'],
    'img_luxury_and_mass_market' => ['start' => 10, 'end' => 0, 'step' => -1, 'path' => 'luxury_and_mass_market', 'prefix' => 'luxury_and_mass_market'],
    'img_fashion_and_pop_culture' => ['start' => 1, 'end' => 11, 'step' => 1, 'path' => 'fashion_and_pop_culture', 'prefix' => 'fashion_and_pop_culture'],

    'img_collaboration_what' => ['start' => 4, 'end' => 0, 'step' => -1, 'path' => 'home_articles_images/collaboration_what', 'prefix' => 'collaboration_what'],
    'art_and_fashion' => ['start' => 0, 'end' => 3, 'step' => 1, 'path' => 'home_articles_images/art_and_fashion', 'prefix' => 'art_and_fashion'],
    'houses_and_artists' => ['start' => 0, 'end' => 6, 'step' => 1, 'path' => 'home_articles_images/houses_and_artists', 'prefix' => 'houses_and_artists'],
    'lux_and_market' => ['start' => 0, 'end' => 14, 'step' => 1, 'path' => 'home_articles_images/lux_and_market', 'prefix' => 'lux_and_market'],
    'fashion_and_pop' => ['start' => 0, 'end' => 3, 'step' => 1, 'path' => 'home_articles_images/fashion_and_pop', 'prefix' => 'fashion_and_pop'],
    'authorisation' => ['start' => 0, 'end' => 0, 'step' => 1, 'path' => 'authorisation', 'prefix' => 'auth'],
    'registration' => ['start' => 0, 'end' => 0, 'step' => 1, 'path' => 'registration', 'prefix' => 'reg'],
];
$imageStrings = generateImages($imageConfig);
## Данные
$articlesDataFashionCollaboration = [
    [
        'Мода и коллаборации: когда искусство встречает моду',
        '',
        'Первая знаковая творческая союзная работа произошла в 30-х годах, когда Эльза Скиаппарелли и Сальвадор Дали объединили моду и сюрреализм. Их встреча стала легендой: Дали заявил, что Скиаппарелли одевается в стиле его картин, а она ответила, что он пишет картины в стиле её платьев. Так зародилось одно из самых ярких сотрудничеств в истории моды./Их первая работа — пудреница в виде циферблата — была лишь началом. Вскоре появились культовые вещи: платье «слезы», шляпа-туфелька и знаменитое платье с изображением лобстера, которое прославила герцогиня Уоллес Симпсон. Эти образы шокировали публику, но стали знаковыми. Позже их идеи многократно переосмысливались, а Дом Schiaparelli сегодня продолжает черпать вдохновение в наследии своей основательницы./В 60-х коллаборации обрели новый смысл. Ив Сен-Лоран, переживая творческий кризис, вдохновился работами Андре Куррежа и книгой о Пите Мондриане. Увидев в геометрических картинах новый язык моды, он создал коллекцию цветных платьев, похожих на ожившие полотна. Их пришлось вручную собирать, как мозаику, но результат произвёл фурор — коллекция 1965 года стала настоящим манифестом искусства в одежде./В 90-х мода все больше пересекалась с поп-культурой. Джанни Версачи и Энди Уорхол стали одними из первых, кто соединил высокую моду и искусство поп-арта. Их дружба зародилась в Нью-Йорке, где художник подарил модельеру его портрет. В 1991 году Версачи посвятил целую коллекцию Уорхолу, украсив платья его культовыми изображениями Мэрилин Монро. Этот союз стал сенсацией, а поп-арт в моде начали активно использовать и другие бренды: Prada, Calvin Klein, Dior./Рэй Кавакубо и Comme des Garçons вывели моду на уровень философии. В 1997 году она представила коллекцию, известную как «горбатая», где одежда деформировала тело и бросала вызов традиционным представлениям о красоте. Её идеи вдохновили знаменитого хореографа Мерса Каннингема, и она создала костюмы для его авангардного спектакля «Сценарио»./Сегодня коллаборации — неотъемлемая часть индустрии моды. Дизайнеры продолжают объединяться с художниками, брендами и поп-культурой, создавая уникальные вещи. От капсул Louis Vuitton до неожиданных союзов Gucci и Adidas — этот тренд только набирает обороты, доказывая, что мода — это не просто одежда, а настоящее искусство.',
        $imageStrings['img_fashion_and_collaboration'],
        2,
        ''
    ],
    [
        'Люкс и масс-маркет',
        'H&M',
        'H&M вошёл в историю благодаря своим коллаборациям с культовыми дизайнерами. Всё началось в 2004 году с Карла Лагерфельда. Это был не просто успех, но и скандал: дизайнер возмутился тем, что H&M сделал одежду для всех размеров, а не только до 42-го, как он привык. Коллекцию раскупили всего за час, что тоже вызвало недовольство Лагерфельда — ему хотелось, чтобы одежда была доступна дольше./В 2007 году Roberto Cavalli привнёс в H&M роскошь: золотые пайетки, леопардовые принты, глубокие вырезы и мини-платья в духе итальянского гламура. Это была одна из самых дорогих коллекций бренда. В 2008 году H&M впервые сотрудничал с Comme des Garçons, предложив нестандартные асимметричные силуэты и крупный гороховый принт, к которому Рей Кавакубо вернулась спустя 10 лет./В 2010 году вышла одна из самых любимых коллекций модников — Lanvin. Альбер Эльбаз создал узнаваемые воздушные платья с асимметричными лифами и шёлковыми лентами. В 2011 году H&M коллабился с Versace: коллекция была настолько популярной, что перед магазинами выстраивались огромные очереди, а сама Донателла Версаче прилетела в Лондон, чтобы поприветствовать фанатов./В 2013 году бренд сделал ставку на минимализм с Maison Margiela. Более 100 позиций включали культовые аксессуары: часы без циферблата, клатчи в форме конфет и пуховики-одеяла. В 2014-м H&M впервые объединился с американским дизайнером — Александром Вангом. В его коллекции были спортивные леггинсы, худи и даже боксёрские перчатки./Но настоящую сенсацию устроил Balmain в 2015 году. Очереди перед магазинами в Париже, Лондоне и Москве начались за день до старта продаж, а сайт H&M просто обрушился. Коллекцию разобрали за полчаса. Она запомнилась футуристичными силуэтами, золотыми и серебряными узорами, металлическими элементами и искусственным мехом./В 2023 году партнёром H&M стал Mugler. Коллекция включала фирменные джинсы с чёрными вставками, облегающие боди с вырезами и обилием кристаллов. Кампания, как всегда, была яркой и провокационной. Не только H&M освоил коллаборации.',
        $imageStrings['img_luxury_and_mass_market'],
        3,
        ''
    ],
    [
        'Мода и поп-культура',
        '',
        "Модные дома часто черпают вдохновение в поп-культуре, создавая коллекции, которые соединяют мир высокой моды и массовых увлечений. Такие коллаборации не только привлекают внимание, но и становятся настоящими символами эпохи./Французский модный дом Givenchy в 2014 году представил коллекцию, вдохновлённую героями Disney, но вместо привычной сказочной эстетики выбрал более мрачный стиль. Принты с Бэмби и сценами из «Короля Льва» приобрели готическую глубину. В 2023 году Givenchy вновь объединился с Disney, выпустив капсульную коллекцию в честь 100-летия студии, на этот раз с акцентом на классическую анимацию./Когда в 2013 году Джереми Скотт возглавил Moschino, бренд моментально стал синонимом китчевой моды. В 2014 году он представил культовую коллекцию, вдохновлённую поп-культурой: платья с принтами Губки Боба, свитеры, повторяющие форму упаковки картофеля фри из McDonald's, и даже аксессуары в виде Happy Meal. Этот эклектичный стиль задал тренд на дерзкие коллаборации, которые позже подхватили Vetements, сотрудничая с DHL, Bounty, McDonald's, PlayStation и Evian./В 2021 году Balenciaga совершил революцию в подаче коллекции, заменив традиционный показ полноценным эпизодом «Симпсонов». Гомер, Мардж и другие жители Спрингфилда примерили знаковые образы бренда, вызвав восторг индустрии. Но ещё в 2007 году герои мультсериала позировали для Harper’s Bazaar в нарядах Versace, Chanel и Louis Vuitton, доказывая, что связь высокой моды и поп-культуры существует давно./Оливье Рустен (Balmain) предсказал массовое помешательство на Барби задолго до премьеры фильма Греты Гервиг. В 2022 году он создал коллекцию в стиле культовой куклы, где преобладали розовые оттенки, корсетные платья и мини-юбки. В 2023 году японская культура также оказалась в центре внимания: Jimmy Choo выпустил коллекцию обуви, вдохновлённую Sailor Moon, а Loewe представил капсулу, посвящённую «Унесённому призраками» и «Ходячему замку»./В России тренд на коллаборации также набирал обороты. Iconica одним из первых заключил партнёрство с Аллой Пугачёвой ещё до того, как само слово «коллаборация» вошло в обиход. Позже бренд сотрудничал с Алёной Ахмадуллиной, Evelina Khromtchenko и Ushatava, создавая эксклюзивные коллекции. Monochrome запомнился своими коллаборациями с Reebok и Pantone, объединяя спорт, цвет и моду./Коллаборации с поп-культурой остаются мощным инструментом в мире моды, превращая одежду в символ эпохи и создавая культовые вещи, которые остаются в истории.",
        $imageStrings['img_fashion_and_pop_culture'],
        4,
        '/video/fashion_pop_culture.mp4'
    ],
    [
        'Войдите в систему или создайте учётную запись',
        '',
        '*Продолжая пользоваться нашей платформой, в том числе через наших партнёров, вы соглашаетесь с нашим пользовательским соглашением и подтверждаете нашу политику конфиденциальности.',
        $imageStrings['authorisation'],
        6,
        ''
    ],
    [
        'Войдите в систему или создайте учётную запись',
        '',
        '*Нажимая на кнопку зарегестрироваться, вы соглашаетесь с нашим пользовательским соглашением и подтверждаете нашу политику конфиденциальности.',
        $imageStrings['registration'],
        7,
        ''
    ]
];

$HomePageData = [
    [
        'Коллаборации… что?',
        '',
        'Так кто же начал этот марафон коллабов и задал тренд на многие десятилетия вперёд?/В 30-е годы Сальвадор Дали и Эльза Скьяпарелли совершили первую в истории моды коллаборацию между художником и кутюрье. По легенде знакомства их произошло так…/Сальвадор Дали сказал «Вы одеваетесь в стиле моих картин», на что она ответила «Нет, это вы пишете картины в стиле моих платьев». Ну а потом все и случилось./В результате их сотрудничества появились знаковые и скандальные вещи, включая «Пудреницу в виде циферблата» в 1935 году. В 1936 году был создан платье «слезы», а в 1937 году — культовая шляпа-туфелька и знаменитое платье с изображением лобстера, которое носила герцогиня Уоллес Симпсон.',
        $imageStrings['img_collaboration_what'],
        1
    ],
    [
        'Когда искусство встречает моду',
        '',
        'Ив Сен-Лоран переживал творческий кризис, пока вдохновение не пришло от Андре Куреша и книги о Пите Мондриане. Это привело к созданию культовых платьев в стиле колор-блокинга, которые пришлось собирать вручную. Показ стал настоящим фурором для всех./В 1997 году Рэй Кавакуба представила концептуальную «горбатую коллекцию», исследующую связь одежды и тела. Эти образы привлекли внимание хореографа Мерса Каннингема, и Кавакуба создала костюмы для перформанса «Сценарио». Тренд взаимодействия моды с искусством только начинался./Джани Версачи подружился с Энди Уорхолом, и в 1991 году посвятил ему коллекцию, ставшую знаковой. Линда Евангелиста примерила платье с изображением Мэрилин Монро, а работы Уорхола вдохновили и другие модные дома.',
        $imageStrings['art_and_fashion'],
        1
    ],
    [
        'Модные дома и художники',
        '«Louis Vuitton X Dior…»',
        'Louis Vuitton долго избегал экспериментов, ассоциируясь с консервативной роскошью, но в 1998 году Марк Джейкобс перезапустил бренд через коллаборации, чтобы омолодить его./В 2001 году бренд сотрудничал с Стивеном Спраузом. Его граффити-надписи украсили сумки, а коллекция стала культовой. В 2009 году коллаборацию переиздали в память о художнике, который скончался от рака./В 2002 году началось партнёрство с Такаси Мураками. Он придал монограмме цвет и добавил мультяшные элементы (цветы сакуры, вишенки). Коллекция стала символом 2000-х, но сотрудничество завершилось в 2015 году, а вещи с этими принтами стали объектами коллекционирования./В 2007 году совместно с Ричардом Принсом вышла коллекция «Медсёстры», вдохновлённая его картинами. Наоми Кэмпбелл, Наталья Водянова и другие супермодели появились на подиуме в белых халатах, кружевных масках и шапочках с логотипом бренда./В 2012 году Яёи Кусама оформила сумки и витрины в свой фирменный горох. В 2023 году второй этап коллаборации разросся до глобального уровня: оформление флагманского бутика, робот-Кусама и массовое внедрение её стиля./В 2017 году Джефф Кунс создал коллекцию сумок с репродукциями великих художников (Да Винчи, Ван Гог, Гоген, Мане и др.). Их выпускали ограниченным тиражом в избранных бутиках и поп-ап-магазинах./В 2018 году Dior при Киме Джонсе сотрудничал с Брайаном Доннелли (KAWS), создав гигантскую скульптуру знаменитого мультперсонажа, капсульную коллекцию и серию игрушек./В арт-коллаборации активно включились Hermès, Prada, Yeezy, Off-White и другие бренды, превращая моду и искусство в единое целое. Теперь люксовые бренды не просто создают одежду, а становятся частью культурного контекста мира моды.',
        $imageStrings['houses_and_artists'],
        1
    ],
    [
        'Люкс и масс-маркет',
        '«H&M, Uniqlo, Supreme, Balenciaga, Puma…»',
        'H&M вошёл в историю благодаря своим коллаборациям с культовыми дизайнерами. Всё началось в 2004 году с Карла Лагерфельда. Это был не просто успех, но и скандал: дизайнер возмутился тем, что H&M сделал одежду для всех размеров, а не только до 42-го, как он привык. Коллекцию раскупили всего за час, что тоже вызвало недовольство Лагерфельда — ему хотелось, чтобы одежда была доступна дольше./В 2007-м Roberto Cavalli представил роскошную линейку с леопардовым принтом и стразами — одну из самых дорогих у H&M. В 2008 году бренд работал с Comme des Garçons, а спустя 10 лет Рей Кавакубо вернулась к культовому гороховому узору./Uniqlo добился успеха в коллаборациях с JW Anderson, сделав сотрудничество регулярным. В 2009 году бренд запустил масштабный проект с Жилем Зандером — коллекция +J насчитывала более 140 предметов и длилась 5 сезонов. Александр Ванг также сотрудничал с Uniqlo дважды — в 2008 и 2018 годах./Supreme взорвал мир моды коллаборацией с Louis Vuitton в 2017 году — уличный стиль впервые оказался на парижском подиуме. Монограммы LV и логотип Supreme украсили рюкзаки, худи и даже бейсбольные биты. В 2019 году бренд повторил успех, объединившись с Жан-Полем Готье./Balenciaga под руководством Демны Гвасалии в 2018 году выпустила культовые Crocs на 10-сантиметровой платформе, а спустя три года — резиновые сапоги./Йоджи Ямамото и Adidas начали сотрудничество в 2003 году, создав футуристичную линию Y-3. Дизайнер вдохновился офисными работниками Нью-Йорка, сочетавшие кроссовки с деловыми костюмами. Первую коллекцию приняли восторженно, и партнёрство продолжается до сих пор./Puma сделала ставку на Рианну в 2014 году — её кроссовки раскупили за 35 минут в США. Затем певица создала линию одежды, а в 2017 году выпустила ювелирную коллекцию с Chopard, вдохновлённую Барбадосом.',
        $imageStrings['lux_and_market'],
        2
    ],
    [
        'Мода и поп-культура',
        '',
        "Модные дома часто черпают вдохновение в поп-культуре. Givenchy выпустил мрачную коллекцию Disney в 2014 году, а в 2023-м – капсулу к столетию студии./Джереми Скотт и Moschino стали синонимами китчевого анимационного стиля: в 2014 году бренд представил культовую коллекцию с Губкой Бобом и McDonald's Couture. Позже подобные смелые решения подхватили Vetements, сотрудничая с DHL, Bounty, McDonald's, PlayStation и Evian./Оливье Рустен (Balmain) предсказал массовое помешательство на Барби, объявив о коллаборации с кукольным брендом ещё до начала тренда. В 2023 году Jimmy Choo выпустил капсулу по мотивам Sailor Moon, а Loewe вдохновился культовыми аниме «Унесённый призраками» и «Ходячий замок».",
        $imageStrings['fashion_and_pop'],
        3
    ]
];

foreach ($articlesDataFashionCollaboration as $data) {
    $name = $conn->real_escape_string($data[0]);
    $author = $conn->real_escape_string($data[1]);
    $description = $conn->real_escape_string($data[2]);
    $images = $conn->real_escape_string($data[3]);
    $pages_id = $data[4] ?? 'NULL';
    $videos = $conn->real_escape_string($data[5]);

    $sql = "INSERT INTO Articles (name, author, description, images, video, pages_id)
            VALUES ('$name', '$author', '$description', '$images', '$videos', $pages_id)";

    if (!$conn->query($sql)) {
        echo "Ошибка вставки в articles: " . $conn->error . "\n";
    }
}

foreach ($HomePageData as $data) {
    $title = $conn->real_escape_string($data[0]);
    $author = $conn->real_escape_string($data[1]);
    $description = $conn->real_escape_string($data[2]);
    $images = $conn->real_escape_string($data[3]);
    $article_id = $conn->real_escape_string($data[4]);

    $sql = "INSERT INTO HomeArticles (title, author, description, images, article_id) VALUES ('$title', '$author', '$description', '$images', '$article_id')";

    if (!$conn->query($sql)) {
        echo "Ошибка вставки в HomeArticles: " . $conn->error . "\n";
    }
}

$conn->close();
?>