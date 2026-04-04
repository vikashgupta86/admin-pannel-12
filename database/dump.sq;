-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2026 at 03:11 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(191) DEFAULT NULL,
  `description` text NOT NULL,
  `subject_type` varchar(191) DEFAULT NULL,
  `event` varchar(191) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(191) DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `batch_uuid` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'posts', 'created', 'Modules\\Post\\Models\\Post', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":1,\"name\":\"Deleniti sit et autem\",\"slug\":\"deleniti-sit-et-autem\",\"intro\":\"Sunt fuga itaque eum possimus inventore et ab. Vitae quibusdam accusamus nulla quaerat molestiae veritatis omnis velit. Consequatur aperiam ut ullam blanditiis ducimus eligendi.\",\"content\":\"Porro quas sunt omnis dolores quo assumenda maxime. Assumenda consequatur id similique pariatur est quia. Culpa saepe magni omnis praesentium quo commodi aspernatur temporibus. Commodi facere harum consectetur qui sapiente.\\n\\nLaborum qui excepturi eum quia nulla nostrum. Iste qui neque et consequatur. Debitis qui qui quaerat voluptatem ut nulla illo. Ad molestiae repellendus voluptate placeat sint modi libero.\\n\\nOfficia reprehenderit voluptas ut et at sed. Beatae voluptate sed et sit. Aut eius laboriosam blanditiis cum numquam sit repudiandae. Ea quod mollitia inventore ipsum laboriosam explicabo perspiciatis.\\n\\nProvident vero molestiae sed praesentium molestias quo. Doloremque omnis et nihil et repellat. Enim nostrum quia unde eum aliquid et. Ea iure aut eos optio quas culpa dolor voluptas. Officia porro sunt libero ea vero ullam rerum.\\n\\nQuisquam labore nulla esse iusto est et. Qui ut natus ad fugiat. Ut suscipit voluptates earum ut quia minus.\\n\\nDicta veritatis dolorem est nisi illo. Qui distinctio eveniet laborum. Soluta reprehenderit occaecati enim cumque.\",\"type\":\"Feature\",\"category_id\":2,\"category_name\":null,\"is_featured\":1,\"image\":\"https:\\/\\/picsum.photos\\/1200\\/630?random=38\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"meta_og_image\":\"\",\"meta_og_url\":\"\",\"hits\":0,\"order\":null,\"status\":\"Unpublished\",\"moderated_by\":null,\"moderated_at\":null,\"created_by\":1,\"created_by_name\":\"Super Admin\",\"created_by_alias\":null,\"updated_by\":1,\"deleted_by\":null,\"published_at\":\"2026-04-03T17:54:50.000000Z\",\"created_at\":\"2026-04-03T17:54:50.000000Z\",\"updated_at\":\"2026-04-03T17:54:50.000000Z\",\"deleted_at\":null}}', NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(2, 'posts', 'created', 'Modules\\Post\\Models\\Post', 'created', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":2,\"name\":\"Rerum qui repellendus aut\",\"slug\":\"rerum-qui-repellendus-aut\",\"intro\":\"Qui sit laboriosam nisi placeat tenetur rerum. Earum commodi ad cumque sunt sint quisquam et. Sit aut totam sapiente dolor veritatis impedit maxime est. Asperiores amet corrupti aut facilis rem.\",\"content\":\"Eaque et alias maxime non illum. Suscipit eveniet temporibus placeat eius quisquam vero unde. Quae recusandae voluptatibus sunt officiis molestias. Dolore illo velit incidunt.\\n\\nInventore aut soluta nulla qui aut. Tempore possimus reiciendis unde itaque enim voluptas. Aut dicta dolor id ex.\\n\\nUnde enim sint harum odit fugiat non qui. Enim id maxime animi voluptatem velit. Eos aperiam ea necessitatibus incidunt quia accusamus. Quos dolorum quia non error excepturi et iusto.\\n\\nOmnis quia illum sapiente ut. Consectetur nesciunt qui libero veritatis sit magnam. Quasi quidem dolores modi autem sint. Repudiandae dolorum amet id.\\n\\nQuidem vel iure autem enim voluptatibus et aut soluta. Eveniet cupiditate explicabo laboriosam perferendis autem at consequatur. Distinctio veniam cupiditate dignissimos laborum magnam. Sequi et ipsum magnam aliquam ipsa.\",\"type\":\"News\",\"category_id\":4,\"category_name\":null,\"is_featured\":1,\"image\":\"https:\\/\\/picsum.photos\\/1200\\/630?random=3\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"meta_og_image\":\"\",\"meta_og_url\":\"\",\"hits\":0,\"order\":null,\"status\":\"Published\",\"moderated_by\":null,\"moderated_at\":null,\"created_by\":1,\"created_by_name\":\"Super Admin\",\"created_by_alias\":null,\"updated_by\":1,\"deleted_by\":null,\"published_at\":\"2026-04-03T17:54:50.000000Z\",\"created_at\":\"2026-04-03T17:54:50.000000Z\",\"updated_at\":\"2026-04-03T17:54:50.000000Z\",\"deleted_at\":null}}', NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(3, 'posts', 'created', 'Modules\\Post\\Models\\Post', 'created', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":3,\"name\":\"Temporibus ut ab qui soluta\",\"slug\":\"temporibus-ut-ab-qui-soluta\",\"intro\":\"Accusamus provident quos architecto et dignissimos praesentium suscipit laboriosam. Modi quo tempore aut dicta.\",\"content\":\"Quae explicabo ut aut ex. Qui tenetur iure repudiandae laborum. Perspiciatis sed quibusdam quia dignissimos sunt fugiat. Provident nam eveniet esse sunt et voluptatem a. Alias suscipit vel et quod.\\n\\nDolorum autem voluptatem repellat dolore sed et. Nihil architecto inventore quaerat quis aut neque facilis. Expedita nihil inventore rerum ut.\\n\\nAut ea voluptates temporibus culpa. Quaerat recusandae necessitatibus itaque iusto repellat non aliquid.\\n\\nItaque magni inventore magnam asperiores. Doloremque repellat ut natus eos impedit qui et. Est omnis molestiae provident qui iusto.\\n\\nEum velit labore quam placeat dolores eveniet at nihil. Unde impedit ut aperiam sit.\\n\\nQuasi provident deleniti quia nostrum facere. Eos iusto explicabo magni nobis ducimus. Qui placeat voluptates incidunt.\",\"type\":\"News\",\"category_id\":5,\"category_name\":null,\"is_featured\":1,\"image\":\"https:\\/\\/picsum.photos\\/1200\\/630?random=35\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"meta_og_image\":\"\",\"meta_og_url\":\"\",\"hits\":0,\"order\":null,\"status\":\"Unpublished\",\"moderated_by\":null,\"moderated_at\":null,\"created_by\":1,\"created_by_name\":\"Super Admin\",\"created_by_alias\":null,\"updated_by\":1,\"deleted_by\":null,\"published_at\":\"2026-04-03T17:54:50.000000Z\",\"created_at\":\"2026-04-03T17:54:50.000000Z\",\"updated_at\":\"2026-04-03T17:54:50.000000Z\",\"deleted_at\":null}}', NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(4, 'posts', 'created', 'Modules\\Post\\Models\\Post', 'created', 4, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":4,\"name\":\"Unde nemo qui eum odio eaque\",\"slug\":\"unde-nemo-qui-eum-odio-eaque\",\"intro\":\"Sint aut et et pariatur. Sed eveniet aperiam culpa assumenda mollitia. Cumque dolores qui corrupti eligendi.\",\"content\":\"Vel eum ullam et non facere. Nostrum earum harum occaecati odit enim animi tenetur. Adipisci est qui eligendi omnis earum eum inventore. Doloremque corporis quis ea qui et.\\n\\nRepellendus unde consequatur eum consequatur eos eos voluptatem. Vero veniam repudiandae dicta dignissimos rerum. Eum doloremque repellendus doloribus sit quidem. Voluptatem necessitatibus maiores voluptatem doloribus.\\n\\nSit optio suscipit error sint aperiam iusto laboriosam. Minus fuga molestiae facere rem excepturi. Iure omnis laudantium molestias neque expedita molestiae facilis delectus. Sed autem nulla nisi adipisci aut rerum sunt neque.\\n\\nVoluptatem harum ut est excepturi. Asperiores aut voluptatibus eaque asperiores consequatur dolorum. Praesentium laboriosam eligendi omnis blanditiis.\\n\\nDolor et impedit tempore commodi nostrum sit. Consequatur et sit aliquid accusamus ut. Cupiditate repellendus vel vel velit vel dolores. Voluptas molestias aspernatur neque nesciunt et neque consequatur aliquam.\\n\\nQuasi harum odit tempore quaerat quis qui sequi. Numquam laborum vitae perspiciatis ad id ex.\\n\\nQui dolor laudantium deserunt doloribus. Debitis aut consequuntur molestiae deserunt voluptatem voluptatum qui. A exercitationem dolorem est sit officiis aut excepturi. Fuga nemo qui vitae sequi rerum.\",\"type\":\"Feature\",\"category_id\":1,\"category_name\":null,\"is_featured\":1,\"image\":\"https:\\/\\/picsum.photos\\/1200\\/630?random=23\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"meta_og_image\":\"\",\"meta_og_url\":\"\",\"hits\":0,\"order\":null,\"status\":\"Unpublished\",\"moderated_by\":null,\"moderated_at\":null,\"created_by\":1,\"created_by_name\":\"Super Admin\",\"created_by_alias\":null,\"updated_by\":1,\"deleted_by\":null,\"published_at\":\"2026-04-03T17:54:50.000000Z\",\"created_at\":\"2026-04-03T17:54:50.000000Z\",\"updated_at\":\"2026-04-03T17:54:50.000000Z\",\"deleted_at\":null}}', NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(5, 'posts', 'created', 'Modules\\Post\\Models\\Post', 'created', 5, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":5,\"name\":\"Qui ea temporibus officiis\",\"slug\":\"qui-ea-temporibus-officiis\",\"intro\":\"Cumque labore incidunt optio cumque nam ab sequi. Quia deleniti esse rerum eum aperiam rerum velit.\",\"content\":\"Rem inventore inventore fuga culpa nisi in neque. Aliquam sit deserunt dolorum voluptatem consectetur consectetur ut.\\n\\nQuas ut fugiat ipsam aut et et. At dolores sed sed earum omnis.\\n\\nIn ut qui eos consequatur tenetur quis iure. Vel non aspernatur consequuntur qui dignissimos.\\n\\nFacere id odio totam sed quos tempora sed. Voluptatum occaecati quasi nemo doloremque necessitatibus deleniti hic. Officia minus architecto modi quaerat minus explicabo veniam.\\n\\nDebitis sapiente quis quia voluptas rem quas omnis nihil. Et sunt excepturi aliquid minus ex. Ratione nam tempora et quasi voluptas quia.\\n\\nEst voluptatem quidem nihil minus. Soluta dolorem iusto id optio voluptatem natus. Blanditiis eaque rerum eum asperiores.\\n\\nUt in eum est maiores. Quidem beatae quasi beatae qui earum laboriosam corrupti. Ea et rerum iste praesentium unde.\",\"type\":\"Article\",\"category_id\":3,\"category_name\":null,\"is_featured\":0,\"image\":\"https:\\/\\/picsum.photos\\/1200\\/630?random=45\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"meta_og_image\":\"\",\"meta_og_url\":\"\",\"hits\":0,\"order\":null,\"status\":\"Published\",\"moderated_by\":null,\"moderated_at\":null,\"created_by\":1,\"created_by_name\":\"Super Admin\",\"created_by_alias\":null,\"updated_by\":1,\"deleted_by\":null,\"published_at\":\"2026-04-03T17:54:50.000000Z\",\"created_at\":\"2026-04-03T17:54:50.000000Z\",\"updated_at\":\"2026-04-03T17:54:50.000000Z\",\"deleted_at\":null}}', NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(6, 'posts', 'created', 'Modules\\Post\\Models\\Post', 'created', 6, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":6,\"name\":\"In dolores quas quisquam et\",\"slug\":\"in-dolores-quas-quisquam-et\",\"intro\":\"Cum excepturi repellat aut. Ut id aperiam iste. Laboriosam pariatur sapiente reiciendis eos sed a necessitatibus sunt. Optio ut animi praesentium quia.\",\"content\":\"Fuga dolorem voluptatum quasi animi dolor. Totam praesentium et similique molestiae ut. Perspiciatis dolores reprehenderit dolores architecto et mollitia quisquam. Deserunt magni animi quia et inventore.\\n\\nEt minus autem earum animi ex dolor. Totam fuga temporibus omnis quidem voluptas ipsa quo. Est consequatur minus placeat voluptatem alias.\\n\\nEx omnis rerum ex eos incidunt. Voluptatem aut neque suscipit velit vel.\\n\\nEveniet voluptatem id perferendis voluptatibus aut voluptatem. At animi magni explicabo qui saepe. Consectetur nihil magni quasi dignissimos consequatur aliquid quisquam tempore. Vero est modi aut ipsa.\\n\\nTempora suscipit sapiente voluptatum est enim perspiciatis. Iure totam non quasi fuga qui. Dolor quia sint sit voluptatem voluptatem qui cupiditate. Officia in ipsam dicta cum.\\n\\nNulla hic architecto consequatur architecto voluptas dolore aperiam. Molestias qui quae voluptatem. Esse tenetur ea non et nihil est et. Delectus et aut amet et. Tenetur modi sint deleniti odio quasi.\",\"type\":\"Article\",\"category_id\":3,\"category_name\":null,\"is_featured\":0,\"image\":\"https:\\/\\/picsum.photos\\/1200\\/630?random=48\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"meta_og_image\":\"\",\"meta_og_url\":\"\",\"hits\":0,\"order\":null,\"status\":\"Unpublished\",\"moderated_by\":null,\"moderated_at\":null,\"created_by\":1,\"created_by_name\":\"Super Admin\",\"created_by_alias\":null,\"updated_by\":1,\"deleted_by\":null,\"published_at\":\"2026-04-03T17:54:50.000000Z\",\"created_at\":\"2026-04-03T17:54:50.000000Z\",\"updated_at\":\"2026-04-03T17:54:50.000000Z\",\"deleted_at\":null}}', NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(7, 'posts', 'created', 'Modules\\Post\\Models\\Post', 'created', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":7,\"name\":\"Nihil in quia cumque eveniet\",\"slug\":\"nihil-in-quia-cumque-eveniet\",\"intro\":\"Qui nisi asperiores quia cumque rerum. Mollitia qui voluptatem et quia ipsum consequuntur quibusdam.\",\"content\":\"Voluptas odio id blanditiis distinctio blanditiis eligendi voluptatem sed. Ea repellat a qui dolor excepturi.\\n\\nSit omnis dolorem non enim ipsum maxime accusantium. Iusto quia architecto adipisci commodi provident. Eligendi sapiente error quis repellendus sed et.\\n\\nIure et quidem est doloribus sint laborum. Ut incidunt laborum corporis rerum asperiores aut et. Delectus voluptas sit ea provident corporis et facilis.\\n\\nAdipisci deserunt molestiae alias ea provident numquam assumenda tempore. Modi est quos consequatur ea voluptate eaque eveniet. Odit repellendus aperiam dolores ipsum.\\n\\nQuas rerum et sed ratione incidunt alias. Et recusandae ut et doloribus rem dolorum. Quis libero voluptatibus quibusdam nesciunt.\\n\\nQuaerat dolore dolor sit ea illo aut. Cum ea reprehenderit saepe. Qui recusandae est dolorem aliquid.\\n\\nId voluptatum velit voluptatem ad eveniet dolores. Nihil incidunt sequi et officiis harum. Reiciendis cupiditate dignissimos porro quas est. Dolores dolores cum odit. Et molestiae quae quas praesentium voluptatibus.\",\"type\":\"Feature\",\"category_id\":3,\"category_name\":null,\"is_featured\":1,\"image\":\"https:\\/\\/picsum.photos\\/1200\\/630?random=34\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"meta_og_image\":\"\",\"meta_og_url\":\"\",\"hits\":0,\"order\":null,\"status\":\"Published\",\"moderated_by\":null,\"moderated_at\":null,\"created_by\":1,\"created_by_name\":\"Super Admin\",\"created_by_alias\":null,\"updated_by\":1,\"deleted_by\":null,\"published_at\":\"2026-04-03T17:54:50.000000Z\",\"created_at\":\"2026-04-03T17:54:50.000000Z\",\"updated_at\":\"2026-04-03T17:54:50.000000Z\",\"deleted_at\":null}}', NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(8, 'posts', 'created', 'Modules\\Post\\Models\\Post', 'created', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":8,\"name\":\"Dolorem odio ut voluptatem\",\"slug\":\"dolorem-odio-ut-voluptatem\",\"intro\":\"Ut omnis enim consequatur velit quaerat quis. At similique officia vel similique harum. Voluptas odio velit et unde unde consequatur. Autem accusamus consequatur porro quam porro non praesentium. Eum quia rerum nemo sint id consequatur.\",\"content\":\"Aliquam dolores nihil debitis reprehenderit. Facilis ullam aut dolorum consequatur nesciunt velit. Natus dolores laudantium rerum nulla quas maxime voluptatem. Reprehenderit soluta quasi sed commodi unde asperiores et.\\n\\nVoluptas doloremque dolores autem impedit. Molestiae et esse ad cumque itaque. Et illum natus aut fuga.\\n\\nPariatur magni est aliquam dolores cumque sit repellendus. Tempora eveniet laborum illum distinctio quia id dolores. Nesciunt ut rem modi illo error. Pariatur reiciendis temporibus vel eius ullam eum dolores. Nihil aut explicabo rem esse porro.\\n\\nDolor laborum impedit nobis. Maiores dolore qui rerum laudantium dolor. Magni fugiat repudiandae rerum corrupti veniam et. Ut ullam et totam est fuga. Repudiandae ipsum porro nobis sed rerum quod perspiciatis consequatur.\\n\\nMolestias vel deserunt est assumenda omnis numquam deleniti. Aut et velit et doloribus laudantium tenetur impedit mollitia. Aut sunt error perferendis placeat exercitationem non perspiciatis. Dignissimos officiis eligendi sit atque et aut.\\n\\nMagnam necessitatibus quia sed quis ut autem. Ratione id voluptates enim. Et quos autem et eum repudiandae et ut.\",\"type\":\"News\",\"category_id\":2,\"category_name\":null,\"is_featured\":1,\"image\":\"https:\\/\\/picsum.photos\\/1200\\/630?random=12\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"meta_og_image\":\"\",\"meta_og_url\":\"\",\"hits\":0,\"order\":null,\"status\":\"Draft\",\"moderated_by\":null,\"moderated_at\":null,\"created_by\":1,\"created_by_name\":\"Super Admin\",\"created_by_alias\":null,\"updated_by\":1,\"deleted_by\":null,\"published_at\":\"2026-04-03T17:54:50.000000Z\",\"created_at\":\"2026-04-03T17:54:50.000000Z\",\"updated_at\":\"2026-04-03T17:54:50.000000Z\",\"deleted_at\":null}}', NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(9, 'posts', 'created', 'Modules\\Post\\Models\\Post', 'created', 9, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":9,\"name\":\"Expedita sed et recusandae\",\"slug\":\"expedita-sed-et-recusandae\",\"intro\":\"Qui autem inventore delectus sunt vero nostrum. Voluptatem est libero facere dignissimos. Officia exercitationem voluptatem delectus velit voluptatem commodi distinctio.\",\"content\":\"Eos unde architecto minus veniam velit ex dolore. Tempore similique aut quisquam et neque quisquam. Doloremque quasi ipsa repellat.\\n\\nAsperiores ullam maxime tempore aut. Repudiandae quo et eos qui ea rerum. Maxime et eos magni in blanditiis possimus.\\n\\nQuia excepturi eaque exercitationem quam quasi porro. Ea vel ut qui vero debitis animi tenetur. Praesentium et esse non.\\n\\nNam eius in nobis consequuntur autem fugit alias quia. Sit vel voluptatem iusto omnis sint. Eligendi aut eligendi rerum eos. Similique et vero molestiae quidem ratione excepturi.\\n\\nIusto est in nostrum et deleniti dolorum ipsa incidunt. Neque nesciunt voluptatem labore sint aperiam. Voluptatem iste rerum voluptas impedit molestiae quos. Veniam quam autem accusamus neque voluptas nihil officia. Veritatis molestias perspiciatis sed esse inventore et aut et.\\n\\nSed quis sint veniam quisquam. Atque eligendi alias deleniti in non tempora.\\n\\nTenetur distinctio voluptate iure vel tempore. Quos sapiente architecto ducimus amet et aut. Ut laboriosam sapiente sint molestiae eos quos.\",\"type\":\"Article\",\"category_id\":3,\"category_name\":null,\"is_featured\":1,\"image\":\"https:\\/\\/picsum.photos\\/1200\\/630?random=32\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"meta_og_image\":\"\",\"meta_og_url\":\"\",\"hits\":0,\"order\":null,\"status\":\"Published\",\"moderated_by\":null,\"moderated_at\":null,\"created_by\":1,\"created_by_name\":\"Super Admin\",\"created_by_alias\":null,\"updated_by\":1,\"deleted_by\":null,\"published_at\":\"2026-04-03T17:54:50.000000Z\",\"created_at\":\"2026-04-03T17:54:50.000000Z\",\"updated_at\":\"2026-04-03T17:54:50.000000Z\",\"deleted_at\":null}}', NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(10, 'posts', 'created', 'Modules\\Post\\Models\\Post', 'created', 10, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":10,\"name\":\"Et possimus aut harum\",\"slug\":\"et-possimus-aut-harum\",\"intro\":\"Aut quia quidem ipsam tenetur quis vel provident. Aliquam cupiditate illo mollitia impedit et tenetur facere.\",\"content\":\"Et laudantium at nemo minus soluta magnam. Magni ut et deleniti consequatur sed. Ipsa deleniti totam odio facere et.\\n\\nSapiente praesentium sint ipsa quisquam aut repudiandae laborum. Molestias sed libero perspiciatis quas beatae. Voluptas vitae atque fuga nihil delectus asperiores. Fugiat expedita facere expedita.\\n\\nModi est ex libero blanditiis deleniti consequuntur dolor. Consequuntur in laborum quia magni officia ex qui. Culpa ratione aut et ipsam pariatur. Ipsum accusamus maxime temporibus quibusdam animi aspernatur.\\n\\nUnde quisquam illum commodi optio. Officia ipsa debitis ipsam debitis. Ducimus qui quia est.\\n\\nMollitia doloribus suscipit aut hic voluptatem repudiandae. Est fugiat in corrupti libero officiis laboriosam fugiat harum. Dolorem adipisci consectetur nostrum et omnis.\\n\\nReprehenderit fugiat reprehenderit repellat quas voluptatem. Temporibus doloribus dolores cumque ratione et sequi. Eum est tempore quod ipsum veniam. Adipisci labore quas eum recusandae.\",\"type\":\"Feature\",\"category_id\":2,\"category_name\":null,\"is_featured\":1,\"image\":\"https:\\/\\/picsum.photos\\/1200\\/630?random=46\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"meta_og_image\":\"\",\"meta_og_url\":\"\",\"hits\":0,\"order\":null,\"status\":\"Published\",\"moderated_by\":null,\"moderated_at\":null,\"created_by\":1,\"created_by_name\":\"Super Admin\",\"created_by_alias\":null,\"updated_by\":1,\"deleted_by\":null,\"published_at\":\"2026-04-03T17:54:50.000000Z\",\"created_at\":\"2026-04-03T17:54:50.000000Z\",\"updated_at\":\"2026-04-03T17:54:50.000000Z\",\"deleted_at\":null}}', NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(11, 'posts', 'created', 'Modules\\Post\\Models\\Post', 'created', 11, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":11,\"name\":\"Animi id qui eveniet\",\"slug\":\"animi-id-qui-eveniet\",\"intro\":\"Velit et et aliquam unde in. Natus aperiam ad sed commodi enim repudiandae incidunt quaerat. Libero consequuntur et sit dolorem voluptatum provident pariatur.\",\"content\":\"Molestiae vitae voluptatem itaque consequatur quas earum. Voluptatem numquam sunt id et.\\n\\nUt maxime perferendis laborum qui dolor. Rem ratione libero nam et eum et et. Sequi voluptatem nobis earum iste cum labore. Provident occaecati optio impedit eligendi aut molestias consequatur.\\n\\nEligendi id commodi quod ratione quibusdam corporis. Numquam voluptas laborum dicta id a impedit.\\n\\nOmnis non et ullam dignissimos. Ut sunt doloremque et hic aut et. Consequatur tempore commodi in ut id voluptas quis.\\n\\nTenetur eveniet libero in non officiis. Quos quis natus animi nihil aperiam. Excepturi in possimus totam laboriosam in iure. Quis officia officia nobis distinctio sed.\\n\\nEt quia et adipisci sapiente. Quia et ea blanditiis nulla sunt modi quas. Non placeat enim optio animi architecto. Mollitia ratione est dolor ullam expedita odit.\",\"type\":\"News\",\"category_id\":4,\"category_name\":null,\"is_featured\":1,\"image\":\"https:\\/\\/picsum.photos\\/1200\\/630?random=22\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"meta_og_image\":\"\",\"meta_og_url\":\"\",\"hits\":0,\"order\":null,\"status\":\"Draft\",\"moderated_by\":null,\"moderated_at\":null,\"created_by\":1,\"created_by_name\":\"Super Admin\",\"created_by_alias\":null,\"updated_by\":1,\"deleted_by\":null,\"published_at\":\"2026-04-03T17:54:50.000000Z\",\"created_at\":\"2026-04-03T17:54:50.000000Z\",\"updated_at\":\"2026-04-03T17:54:50.000000Z\",\"deleted_at\":null}}', NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(12, 'posts', 'created', 'Modules\\Post\\Models\\Post', 'created', 12, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":12,\"name\":\"Assumenda est illo maxime\",\"slug\":\"assumenda-est-illo-maxime\",\"intro\":\"Ut tenetur cupiditate et at iure qui quo. Enim deserunt tempore sequi soluta. Reiciendis quia ut qui eveniet ab pariatur tempora voluptas. Iusto porro qui ex facere quo est.\",\"content\":\"Itaque rerum voluptate fuga dolore laboriosam cum suscipit. Quod facere laudantium laudantium animi. In pariatur est ut quas commodi ut recusandae eaque. Deleniti tenetur dolores et nisi sit illum et nobis.\\n\\nSuscipit distinctio magnam alias et quisquam in. Laudantium consequatur ratione minima beatae sit eum. Tempora tempore eveniet quia laboriosam. Sapiente sint delectus et totam excepturi commodi labore.\\n\\nPlaceat sint et sed. Tempora debitis impedit consequatur quos ut beatae dolorem deserunt.\\n\\nEt provident neque sunt et. Aut assumenda et rerum non incidunt. Iure et amet ad blanditiis. Necessitatibus et consequatur quo id optio vitae ipsa.\\n\\nCorrupti quia voluptatem cum accusantium voluptas et. Laudantium nesciunt itaque veniam minus tempora quaerat. Quis et aut omnis ea soluta dignissimos.\\n\\nEsse libero at officia distinctio nulla quidem et. Maxime veniam harum ea est molestiae illo nemo quas. Exercitationem illum quia rerum velit.\\n\\nTenetur molestiae soluta necessitatibus deserunt. Omnis quos harum qui distinctio repellat consequatur ut. Dolores facilis mollitia aut. Accusantium saepe voluptatum perspiciatis dignissimos sit qui dolores beatae.\",\"type\":\"News\",\"category_id\":5,\"category_name\":null,\"is_featured\":0,\"image\":\"https:\\/\\/picsum.photos\\/1200\\/630?random=46\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"meta_og_image\":\"\",\"meta_og_url\":\"\",\"hits\":0,\"order\":null,\"status\":\"Draft\",\"moderated_by\":null,\"moderated_at\":null,\"created_by\":1,\"created_by_name\":\"Super Admin\",\"created_by_alias\":null,\"updated_by\":1,\"deleted_by\":null,\"published_at\":\"2026-04-03T17:54:50.000000Z\",\"created_at\":\"2026-04-03T17:54:50.000000Z\",\"updated_at\":\"2026-04-03T17:54:50.000000Z\",\"deleted_at\":null}}', NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(13, 'posts', 'created', 'Modules\\Post\\Models\\Post', 'created', 13, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":13,\"name\":\"Odio saepe est recusandae\",\"slug\":\"odio-saepe-est-recusandae\",\"intro\":\"Vitae consectetur quibusdam quae sit. Neque iusto eveniet dolore nihil aliquid. Voluptatibus nam voluptatem iusto at. Dolore eum harum explicabo deserunt vel quo.\",\"content\":\"Non adipisci fuga autem ipsam praesentium numquam nihil. In rerum voluptatem nihil veritatis molestiae perferendis. Neque natus quo aut quis. Dolorem sunt mollitia provident maxime.\\n\\nExpedita quia eum quasi praesentium. Ea quis dicta voluptas quaerat. Temporibus consequuntur beatae eos veritatis vitae corrupti.\\n\\nOptio soluta suscipit reprehenderit. Sequi sit illum molestiae. Qui sint illo voluptatibus rerum.\\n\\nIn tempora in et quo. Repellendus pariatur qui magnam.\\n\\nOptio aliquid commodi expedita impedit dolorem vero quis est. Autem perferendis voluptas quibusdam laboriosam aliquid quia et. Hic consequatur sequi quas ut recusandae. Placeat nulla qui eligendi porro eos odit at ullam. Et aliquam at illum ea magnam.\\n\\nOfficiis omnis est et suscipit ipsa optio dignissimos. Cum sequi ex et ipsam nobis consequatur. Architecto doloremque sed facere velit tempore ipsa voluptatem. A molestiae commodi et dolor ut natus cumque.\\n\\nRecusandae eaque consequatur omnis. Molestiae et earum voluptatibus dolor consequatur quos.\",\"type\":\"Article\",\"category_id\":3,\"category_name\":null,\"is_featured\":0,\"image\":\"https:\\/\\/picsum.photos\\/1200\\/630?random=13\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"meta_og_image\":\"\",\"meta_og_url\":\"\",\"hits\":0,\"order\":null,\"status\":\"Unpublished\",\"moderated_by\":null,\"moderated_at\":null,\"created_by\":1,\"created_by_name\":\"Super Admin\",\"created_by_alias\":null,\"updated_by\":1,\"deleted_by\":null,\"published_at\":\"2026-04-03T17:54:50.000000Z\",\"created_at\":\"2026-04-03T17:54:50.000000Z\",\"updated_at\":\"2026-04-03T17:54:50.000000Z\",\"deleted_at\":null}}', NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(14, 'posts', 'created', 'Modules\\Post\\Models\\Post', 'created', 14, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":14,\"name\":\"Hic non recusandae et qui\",\"slug\":\"hic-non-recusandae-et-qui\",\"intro\":\"Reiciendis natus eum error corporis sed. Sequi quaerat dolorem tempora eveniet.\",\"content\":\"Odit molestias quod quo soluta ut ea. Illum aut corporis illum doloremque. Tempora similique facilis et veniam perspiciatis. Nihil impedit eaque aut et officia.\\n\\nMagnam et quae maiores aut voluptates fugit molestiae quam. Ut suscipit id eius doloribus veniam. Voluptatem repellendus aut quos numquam.\\n\\nAperiam quis voluptas voluptatem et voluptas cumque repellat. Commodi perferendis voluptatem fugiat rerum. Qui magni quia exercitationem ut quo enim. Quibusdam voluptas porro sint eius ea sint.\\n\\nOfficia ut sed similique vero laboriosam. Assumenda ea blanditiis hic sunt alias nemo commodi. Praesentium consequatur atque beatae ipsa aspernatur vero.\\n\\nId hic consequatur earum et facere unde molestias nisi. Voluptatem incidunt reiciendis cumque. Et et suscipit vero voluptatibus.\\n\\nAutem rerum tempore aliquid quo soluta temporibus. Sunt aut rem sed. Distinctio aut autem laudantium corrupti veritatis pariatur inventore.\",\"type\":\"Feature\",\"category_id\":3,\"category_name\":null,\"is_featured\":1,\"image\":\"https:\\/\\/picsum.photos\\/1200\\/630?random=25\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"meta_og_image\":\"\",\"meta_og_url\":\"\",\"hits\":0,\"order\":null,\"status\":\"Published\",\"moderated_by\":null,\"moderated_at\":null,\"created_by\":1,\"created_by_name\":\"Super Admin\",\"created_by_alias\":null,\"updated_by\":1,\"deleted_by\":null,\"published_at\":\"2026-04-03T17:54:50.000000Z\",\"created_at\":\"2026-04-03T17:54:50.000000Z\",\"updated_at\":\"2026-04-03T17:54:50.000000Z\",\"deleted_at\":null}}', NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(15, 'posts', 'created', 'Modules\\Post\\Models\\Post', 'created', 15, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":15,\"name\":\"Iste modi sit officia et ut\",\"slug\":\"iste-modi-sit-officia-et-ut\",\"intro\":\"Omnis ab natus est tempora rerum quis accusamus. Commodi repellendus quis molestiae explicabo et placeat est iste. Ut et sed harum ea dolore blanditiis.\",\"content\":\"Aspernatur in rerum omnis quisquam. Facere vitae amet aut omnis dolores magnam quidem. Quas temporibus est quod dolorem et quis tenetur.\\n\\nSed asperiores consequatur modi totam et. Totam accusamus omnis similique perspiciatis minima. Consequatur voluptatem dolor vitae et exercitationem voluptas reiciendis. Et non aut beatae harum consequatur. Aut vitae ea deserunt atque nam eveniet.\\n\\nQuibusdam deleniti reprehenderit nulla. Voluptatem voluptatibus et sit qui. Ipsam in vel et assumenda minima cupiditate laborum.\\n\\nIure veritatis nulla optio ipsum minus magni aut. Vel laudantium dicta alias autem deleniti. Quidem iste quis nesciunt dicta nostrum laboriosam. Et sed consequatur voluptatibus veritatis doloribus quae. Id dolorum eligendi et.\\n\\nEt quas facilis libero a qui reprehenderit. Ut voluptatem et excepturi aut omnis eligendi ut. Facere nesciunt sapiente nemo in repellat culpa quam.\",\"type\":\"News\",\"category_id\":5,\"category_name\":null,\"is_featured\":1,\"image\":\"https:\\/\\/picsum.photos\\/1200\\/630?random=43\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"meta_og_image\":\"\",\"meta_og_url\":\"\",\"hits\":0,\"order\":null,\"status\":\"Published\",\"moderated_by\":null,\"moderated_at\":null,\"created_by\":1,\"created_by_name\":\"Super Admin\",\"created_by_alias\":null,\"updated_by\":1,\"deleted_by\":null,\"published_at\":\"2026-04-03T17:54:50.000000Z\",\"created_at\":\"2026-04-03T17:54:50.000000Z\",\"updated_at\":\"2026-04-03T17:54:50.000000Z\",\"deleted_at\":null}}', NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(16, 'posts', 'created', 'Modules\\Post\\Models\\Post', 'created', 16, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":16,\"name\":\"Et ullam iste quas\",\"slug\":\"et-ullam-iste-quas\",\"intro\":\"Eveniet animi deserunt veritatis cumque. Eius sed voluptatum quisquam cumque adipisci. Laboriosam ut magnam voluptatibus modi eligendi. Animi praesentium occaecati sed porro dolorum magni voluptatibus. Blanditiis tenetur at aliquid quas totam.\",\"content\":\"Commodi mollitia reprehenderit alias quia eum et. Quia molestias voluptas consequatur molestiae nam. Laboriosam qui sunt consectetur. Et odit velit voluptatem sapiente.\\n\\nQui deleniti voluptate sint laboriosam aut. Cupiditate quia quasi voluptatem facilis aut. Qui possimus aut ex accusamus fuga est.\\n\\nExercitationem consequatur rerum sed libero debitis. Consequatur harum culpa aut incidunt harum dolores occaecati. Autem qui omnis distinctio vero eligendi illum. Hic nobis autem nobis repellendus voluptatem dolore aut.\\n\\nQuam deleniti et consequatur et ducimus. Ipsa porro sint officiis. Nobis sunt reiciendis aspernatur quis. Quia ut nemo deleniti et ea ea.\\n\\nPerferendis et dolor recusandae voluptate a libero. Ut ipsa rerum maiores. Aut aut quidem recusandae aut praesentium laboriosam facere.\",\"type\":\"News\",\"category_id\":4,\"category_name\":null,\"is_featured\":1,\"image\":\"https:\\/\\/picsum.photos\\/1200\\/630?random=35\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"meta_og_image\":\"\",\"meta_og_url\":\"\",\"hits\":0,\"order\":null,\"status\":\"Draft\",\"moderated_by\":null,\"moderated_at\":null,\"created_by\":1,\"created_by_name\":\"Super Admin\",\"created_by_alias\":null,\"updated_by\":1,\"deleted_by\":null,\"published_at\":\"2026-04-03T17:54:50.000000Z\",\"created_at\":\"2026-04-03T17:54:50.000000Z\",\"updated_at\":\"2026-04-03T17:54:50.000000Z\",\"deleted_at\":null}}', NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(17, 'posts', 'created', 'Modules\\Post\\Models\\Post', 'created', 17, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":17,\"name\":\"Et qui mollitia impedit quia\",\"slug\":\"et-qui-mollitia-impedit-quia\",\"intro\":\"Libero quaerat vitae est alias. Explicabo sapiente saepe debitis quo sed eos. Vitae animi enim excepturi incidunt voluptas. Non expedita non est architecto necessitatibus asperiores dolor.\",\"content\":\"Hic quam debitis placeat repellat magni. Sunt occaecati nemo numquam deleniti vero sit. Nemo eius quo quasi veritatis. Blanditiis accusamus ab modi in consequatur vel velit.\\n\\nPossimus tempora dolor rem eum facilis dolores. Voluptas odit rerum laborum natus autem veniam facilis eveniet. Nobis commodi sequi distinctio. Qui eum et esse adipisci dicta est voluptatem. Error tenetur quia eveniet temporibus placeat.\\n\\nQui culpa eos voluptatem ipsam error pariatur. Dolor nihil corrupti aut laudantium quasi. Consequatur error aut velit et consequatur. Ut placeat quod nulla dolores.\\n\\nIn quis ea cupiditate ut eaque accusamus. Culpa accusantium et possimus rerum fuga saepe suscipit. Ex voluptatum omnis iure qui. Impedit nostrum non eveniet eos.\\n\\nAut vel nobis ut qui nisi sapiente. Expedita aperiam fugiat voluptatem eligendi vel.\",\"type\":\"Feature\",\"category_id\":2,\"category_name\":null,\"is_featured\":1,\"image\":\"https:\\/\\/picsum.photos\\/1200\\/630?random=26\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"meta_og_image\":\"\",\"meta_og_url\":\"\",\"hits\":0,\"order\":null,\"status\":\"Published\",\"moderated_by\":null,\"moderated_at\":null,\"created_by\":1,\"created_by_name\":\"Super Admin\",\"created_by_alias\":null,\"updated_by\":1,\"deleted_by\":null,\"published_at\":\"2026-04-03T17:54:50.000000Z\",\"created_at\":\"2026-04-03T17:54:50.000000Z\",\"updated_at\":\"2026-04-03T17:54:50.000000Z\",\"deleted_at\":null}}', NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(18, 'posts', 'created', 'Modules\\Post\\Models\\Post', 'created', 18, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":18,\"name\":\"Dolorum esse quis a\",\"slug\":\"dolorum-esse-quis-a\",\"intro\":\"Necessitatibus consequatur cum quibusdam tempora vel. Et cum soluta ab atque quasi sed doloremque. Impedit similique cupiditate pariatur qui rem quae.\",\"content\":\"Qui placeat error ab et fugiat voluptates qui id. Eligendi nisi excepturi aut provident est explicabo est molestiae. Aut optio rerum est occaecati ea repellendus molestiae.\\n\\nNecessitatibus possimus et a amet omnis doloribus. Itaque distinctio ratione veniam qui. Nobis alias sequi omnis eos ea quia.\\n\\nExercitationem necessitatibus incidunt suscipit minus magnam. Amet magnam facere itaque aut facilis alias. Beatae qui corporis in. Est voluptatem impedit est autem magnam.\\n\\nBeatae et nihil unde ipsum fugiat a repellendus saepe. Aperiam sapiente velit qui rem quasi voluptatibus. Et est excepturi autem fugiat sit animi. Nesciunt ipsa natus et quia voluptatem ut libero exercitationem.\\n\\nQuis accusantium repellat a facilis sequi tenetur similique id. Mollitia voluptatem distinctio est.\",\"type\":\"Article\",\"category_id\":1,\"category_name\":null,\"is_featured\":0,\"image\":\"https:\\/\\/picsum.photos\\/1200\\/630?random=1\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"meta_og_image\":\"\",\"meta_og_url\":\"\",\"hits\":0,\"order\":null,\"status\":\"Draft\",\"moderated_by\":null,\"moderated_at\":null,\"created_by\":1,\"created_by_name\":\"Super Admin\",\"created_by_alias\":null,\"updated_by\":1,\"deleted_by\":null,\"published_at\":\"2026-04-03T17:54:50.000000Z\",\"created_at\":\"2026-04-03T17:54:50.000000Z\",\"updated_at\":\"2026-04-03T17:54:50.000000Z\",\"deleted_at\":null}}', NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(19, 'posts', 'created', 'Modules\\Post\\Models\\Post', 'created', 19, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":19,\"name\":\"Voluptas dolor rerum unde\",\"slug\":\"voluptas-dolor-rerum-unde\",\"intro\":\"Eligendi molestiae quidem quis atque aut debitis veniam. Vel laboriosam facere repellendus repellat officiis quia eaque inventore. Maiores sunt a fuga tenetur.\",\"content\":\"Aspernatur est iste quas. Sed saepe officiis sit ut ullam saepe odit voluptates. Dolor fugit sit officiis et adipisci doloremque harum. Modi minus hic consequatur voluptatum excepturi hic.\\n\\nUt labore minima maiores ratione nobis. Nam ad voluptas autem aut error dolorem. Neque voluptas velit deserunt porro dolorum rerum est.\\n\\nRem assumenda omnis quo pariatur. Non cumque similique animi sint aut odio deleniti cumque. Recusandae quisquam iste perspiciatis tempora adipisci corporis.\\n\\nMolestiae iusto id enim omnis id molestiae adipisci. Dolorem quia placeat voluptas modi non quia provident adipisci. Et temporibus qui dolore sint ipsa nihil eius. Et voluptatem voluptatem sed porro quae quos saepe sint.\\n\\nAnimi et et inventore exercitationem asperiores asperiores laudantium. Magni sit nemo ut esse. Est laudantium amet est dolor dolores officiis in. Doloribus optio totam iure fugiat eum est omnis.\\n\\nMaxime sit quos quia rem et perferendis animi. Quo et suscipit repellat fugiat. Et dolor iusto minima. Placeat aut dolor voluptatibus laudantium.\\n\\nUt pariatur consequatur magnam aut ex maiores. Laudantium eaque ut quos iusto ea id. Reprehenderit iure accusamus a esse molestias voluptates temporibus.\",\"type\":\"Article\",\"category_id\":2,\"category_name\":null,\"is_featured\":0,\"image\":\"https:\\/\\/picsum.photos\\/1200\\/630?random=42\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"meta_og_image\":\"\",\"meta_og_url\":\"\",\"hits\":0,\"order\":null,\"status\":\"Unpublished\",\"moderated_by\":null,\"moderated_at\":null,\"created_by\":1,\"created_by_name\":\"Super Admin\",\"created_by_alias\":null,\"updated_by\":1,\"deleted_by\":null,\"published_at\":\"2026-04-03T17:54:50.000000Z\",\"created_at\":\"2026-04-03T17:54:50.000000Z\",\"updated_at\":\"2026-04-03T17:54:50.000000Z\",\"deleted_at\":null}}', NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(20, 'posts', 'created', 'Modules\\Post\\Models\\Post', 'created', 20, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":20,\"name\":\"Qui vitae adipisci aut\",\"slug\":\"qui-vitae-adipisci-aut\",\"intro\":\"Facere dolore iste qui repellat eum molestiae laboriosam. Quasi vel cupiditate non est. Ut illum ipsa ullam et.\",\"content\":\"Nemo cum cumque eius perferendis veritatis. Vero quod quae expedita neque saepe voluptatem vel.\\n\\nEt ab non eveniet reprehenderit ut illum. Cupiditate rem vitae dolorem quasi excepturi. Velit id harum eligendi fugit omnis reiciendis et. Sed molestiae odit reprehenderit beatae atque et.\\n\\nDolor perferendis alias cum commodi voluptas id. Vel et numquam minus deserunt quisquam qui. Officiis est sed sed enim consequatur impedit consequatur. Quia ea sapiente labore laboriosam magni voluptatum.\\n\\nFuga exercitationem perferendis sapiente praesentium. Esse sed deleniti officiis vitae harum dignissimos aut nihil. Soluta laboriosam et et est qui in. Placeat enim asperiores perferendis fugit saepe corrupti.\\n\\nIpsa ullam dignissimos doloremque incidunt autem est. Eos magnam esse sed fuga consequatur. Distinctio nostrum sed et accusamus aliquid dolore consectetur. Ipsa dolores voluptatibus hic molestias.\\n\\nMolestias odio est consequatur velit sed aliquid. Eum animi cum deleniti ipsa. Ab iure laboriosam laudantium omnis qui blanditiis. Necessitatibus ipsa est libero velit at officia vel.\",\"type\":\"Article\",\"category_id\":5,\"category_name\":null,\"is_featured\":0,\"image\":\"https:\\/\\/picsum.photos\\/1200\\/630?random=6\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_description\":\"\",\"meta_og_image\":\"\",\"meta_og_url\":\"\",\"hits\":0,\"order\":null,\"status\":\"Published\",\"moderated_by\":null,\"moderated_at\":null,\"created_by\":1,\"created_by_name\":\"Super Admin\",\"created_by_alias\":null,\"updated_by\":1,\"deleted_by\":null,\"published_at\":\"2026-04-03T17:54:50.000000Z\",\"created_at\":\"2026-04-03T17:54:50.000000Z\",\"updated_at\":\"2026-04-03T17:54:50.000000Z\",\"deleted_at\":null}}', NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(191) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` varchar(191) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `group_name` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `meta_title` varchar(191) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'Active',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `group_name`, `image`, `meta_title`, `meta_description`, `meta_keyword`, `order`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sint assumenda', 'sint-assumenda', 'Dolores minus amet debitis facere quod. A exercitationem quod in eveniet. Ducimus ratione at numquam ut.', NULL, NULL, NULL, NULL, NULL, NULL, 'Draft', 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(2, 'Aspernatur nam', 'aspernatur-nam', 'Pariatur repellendus velit a voluptates quia ab fugiat. Ea molestiae ea ut unde omnis in. Quas aliquid non minus quasi.', NULL, NULL, NULL, NULL, NULL, NULL, 'Inactive', 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(3, 'Accusamus', 'accusamus', 'Sequi aut enim quas suscipit minima qui. Impedit est aperiam quis qui culpa dolore omnis. Nobis rerum aperiam tempore libero excepturi quaerat.', NULL, NULL, NULL, NULL, NULL, NULL, 'Inactive', 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(4, 'Illum nemo', 'illum-nemo', 'Rem sit quis porro consequatur neque earum. Eum ut consequatur excepturi libero. Ratione animi dolores repellat consequuntur quo numquam. Sint neque dolor consectetur vel dolorem et.', NULL, NULL, NULL, NULL, NULL, NULL, 'Draft', 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(5, 'Sunt pariatur', 'sunt-pariatur', 'Est laboriosam omnis voluptatem at dolores voluptas. Incidunt quisquam ad eum. Atque rem aut adipisci consequatur sint. Inventore quae ab earum distinctio tenetur et dolorum. Voluptatem totam sed magni qui.', NULL, NULL, NULL, NULL, NULL, NULL, 'Inactive', 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(6, 'Ipsam iusto ab', 'ipsam-iusto-ab', 'Eius optio alias porro ratione. Velit autem incidunt explicabo sed eum. Quia ut nihil et enim. Maxime est dolores voluptatem perferendis et voluptas. Nisi et et delectus quia quibusdam.', NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(7, 'Illum quia', 'illum-quia', 'Rerum pariatur qui voluptatem ducimus ab. Voluptas est qui amet delectus consequatur occaecati. Corrupti maxime dicta doloribus similique eligendi inventore error. Labore quisquam nemo odit minima possimus nihil. Qui fuga dolor aut earum sunt.', NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(8, 'Repellat ex', 'repellat-ex', 'Eveniet laboriosam delectus praesentium voluptatem. Placeat vitae non omnis nemo. Labore placeat aut autem illum et molestias quia.', NULL, NULL, NULL, NULL, NULL, NULL, 'Draft', 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(9, 'Debitis fugit', 'debitis-fugit', 'Et ut facere velit est et. Vero quos blanditiis numquam aspernatur cumque qui. Nemo quia voluptatum quia corrupti dolorum.', NULL, NULL, NULL, NULL, NULL, NULL, 'Inactive', 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(10, 'Enim qui', 'enim-qui', 'Rerum nihil eligendi vitae et sapiente nulla iure. Est fugit quasi quibusdam consequatur autem rerum sit. Ut repellat qui dolor hic aut laudantium. Quis consequuntur sit aliquid qui vel quo.', NULL, NULL, NULL, NULL, NULL, NULL, 'Inactive', 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(11, 'In asperiores', 'in-asperiores', 'Quaerat magni et voluptatum dolor. Cum animi nulla praesentium. Saepe sint reiciendis porro illo consequatur sint asperiores. Unde et et consectetur omnis et.', NULL, NULL, NULL, NULL, NULL, NULL, 'Inactive', 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(12, 'Quod et', 'quod-et', 'Cumque aut at minima totam earum ducimus soluta. Fugiat ut ut debitis molestias qui harum. Voluptatibus voluptatem quis magnam repudiandae ullam dolor. Ratione cumque voluptate magnam aut.', NULL, NULL, NULL, NULL, NULL, NULL, 'Inactive', 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(13, 'Dolorem vel', 'dolorem-vel', 'Porro aliquid numquam nam commodi et. Eius quia officia autem reiciendis neque at eos. Totam minima et at dolorem architecto.', NULL, NULL, NULL, NULL, NULL, NULL, 'Inactive', 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(14, 'Minima maxime', 'minima-maxime', 'Molestiae id repellat qui velit. Laboriosam aut pariatur vel. Omnis sint hic minima quo iste. Sed a maxime animi quidem pariatur asperiores.', NULL, NULL, NULL, NULL, NULL, NULL, 'Inactive', 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(15, 'Tenetur', 'tenetur', 'Omnis libero qui ipsum sit est. Sed eum quisquam unde laudantium.', NULL, NULL, NULL, NULL, NULL, NULL, 'Inactive', 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(16, 'Ratione minus', 'ratione-minus', 'Quo sed dolorum fuga incidunt. Iure molestias ut adipisci. Tempora est odio veritatis. Voluptatem corrupti veritatis quam consectetur sit laudantium. Alias qui ullam possimus asperiores.', NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(17, 'Cupiditate', 'cupiditate', 'Itaque est reiciendis ut cumque. Dolores recusandae iure est ut eos natus et voluptatibus. Autem odit corrupti deleniti possimus vero. Omnis nemo voluptatem aliquid aut.', NULL, NULL, NULL, NULL, NULL, NULL, 'Draft', 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(18, 'Sed laboriosam', 'sed-laboriosam', 'Quis provident et porro ut pariatur voluptatem numquam. Ipsum optio cupiditate iste id. Temporibus ipsum quod et. Et qui laboriosam nisi eum blanditiis non.', NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(19, 'Consectetur', 'consectetur', 'Unde natus enim perspiciatis voluptatem. Voluptatibus quia quo eum cum. Totam recusandae natus illo qui doloribus rerum eum.', NULL, NULL, NULL, NULL, NULL, NULL, 'Draft', 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(20, 'Et cupiditate', 'et-cupiditate', 'Itaque sint vero aliquam officia dolor. Tempore sed in sunt quia. Quisquam quaerat eos doloremque beatae. In perspiciatis iure eos modi magnam aut est.', NULL, NULL, NULL, NULL, NULL, NULL, 'Inactive', 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `collection_name` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `file_name` varchar(191) NOT NULL,
  `mime_type` varchar(191) DEFAULT NULL,
  `disk` varchar(191) NOT NULL,
  `conversions_disk` varchar(191) DEFAULT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`manipulations`)),
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`custom_properties`)),
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`generated_conversions`)),
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`responsive_images`)),
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(191) NOT NULL,
  `theme` varchar(191) NOT NULL DEFAULT 'default',
  `css_classes` text DEFAULT NULL,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`)),
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`roles`)),
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  `locale` varchar(191) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `slug`, `description`, `location`, `theme`, `css_classes`, `settings`, `permissions`, `roles`, `is_public`, `is_active`, `is_visible`, `locale`, `note`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Top Nav', 'top-nav', 'Main navigation menu for the website header', 'frontend-header', 'bootstrap', 'navbar navbar-expand-lg', '{\"max_depth\":3,\"cache_duration\":60}', NULL, NULL, 1, 1, 1, 'en', 'Primary navigation for all frontend pages', 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(2, 'Footer Menu', 'footer-menu', 'Footer navigation menu', 'admin-sidebar', 'minimal', 'footer-nav', '{\"max_depth\":\"1\",\"cache_duration\":\"120\"}', NULL, NULL, 1, 1, 1, 'en', 'Footer links for additional navigation', 0, NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-04 08:10:43', NULL),
(3, 'Admin Sidebar', 'admin-sidebar', 'Administrative backend navigation', 'admin-sidebar', 'dark', 'sidebar-nav', '{\"max_depth\":2,\"cache_duration\":30}', '[\"view_backend\"]', NULL, 0, 1, 1, 'en', 'Backend administrative navigation menu', 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(4, 'Main Links', 'main-links', NULL, '4', 'default', NULL, '{\"max_depth\":\"4\",\"cache_duration\":null}', NULL, NULL, 1, 1, 1, 'en', NULL, 1, 1, 1, NULL, '2026-04-03 23:16:58', '2026-04-03 23:16:58', NULL),
(5, 'General Type', 'general-type', NULL, '4', 'default', NULL, '{\"max_depth\":null,\"cache_duration\":null}', NULL, NULL, 1, 1, 1, NULL, NULL, 1, 1, 1, NULL, '2026-04-04 08:14:48', '2026-04-04 08:14:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(191) NOT NULL DEFAULT 'link',
  `url` varchar(191) DEFAULT NULL,
  `route_name` varchar(191) DEFAULT NULL,
  `route_parameters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`route_parameters`)),
  `opens_new_tab` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `depth` int(11) NOT NULL DEFAULT 0,
  `path` varchar(191) DEFAULT NULL,
  `icon` varchar(191) DEFAULT NULL,
  `badge_text` varchar(191) DEFAULT NULL,
  `badge_color` varchar(191) DEFAULT NULL,
  `css_classes` text DEFAULT NULL,
  `html_attributes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`html_attributes`)),
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`)),
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`roles`)),
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `locale` varchar(191) DEFAULT NULL,
  `meta_title` varchar(191) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` varchar(191) DEFAULT NULL,
  `custom_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`custom_data`)),
  `note` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `parent_id`, `name`, `slug`, `description`, `type`, `url`, `route_name`, `route_parameters`, `opens_new_tab`, `sort_order`, `depth`, `path`, `icon`, `badge_text`, `badge_color`, `css_classes`, `html_attributes`, `permissions`, `roles`, `is_visible`, `is_active`, `locale`, `meta_title`, `meta_description`, `meta_keywords`, `custom_data`, `note`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, NULL, 'Home', 'home', 'Homepage link', 'external', '/', NULL, NULL, 0, 0, 0, NULL, 'fa-solid fa-home', NULL, NULL, 'nav-link', NULL, NULL, NULL, 1, 1, 'en', 'Home', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(2, 1, NULL, 'Posts', 'posts', 'Blog posts', 'link', NULL, 'frontend.posts.index', NULL, 0, 1, 0, NULL, 'fa-regular fa-file-lines', NULL, NULL, 'nav-link', NULL, NULL, NULL, 1, 1, 'en', 'Posts', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(3, 1, NULL, 'Categories', 'categories', 'Content categories', 'link', NULL, 'frontend.categories.index', NULL, 0, 2, 0, NULL, 'fa-solid fa-diagram-project', NULL, NULL, 'nav-link', NULL, NULL, NULL, 1, 1, 'en', 'Categories', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(4, 1, NULL, 'Tags', 'tags', 'Content tags', 'link', NULL, 'frontend.tags.index', NULL, 0, 3, 0, NULL, 'fa-solid fa-tags', NULL, NULL, 'nav-link', NULL, NULL, NULL, 1, 1, 'en', 'Tags', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(5, 1, NULL, 'Dropdown', 'dropdown', 'Dropdown menu example', 'dropdown', NULL, '#', NULL, 0, 5, 0, NULL, 'fa-solid fa-chevron-down', NULL, NULL, 'nav-link dropdown-toggle', NULL, NULL, NULL, 1, 1, 'en', 'Dropdown', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(6, 2, NULL, 'About', 'about-us', 'About page', 'link', '#', NULL, NULL, 0, 0, 0, NULL, 'fa-solid fa-info-circle', NULL, NULL, 'footer-link', NULL, NULL, NULL, 1, 1, 'en', 'About', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(7, 2, NULL, 'Privacy', 'privacy', 'Privacy policy', 'link', NULL, 'frontend.privacy', NULL, 0, 1, 0, NULL, 'fa-solid fa-shield-alt', NULL, NULL, 'footer-link', NULL, NULL, NULL, 1, 1, 'en', 'Privacy', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(8, 2, NULL, 'Terms', 'terms', 'Terms of service', 'link', NULL, 'frontend.terms', NULL, 0, 2, 0, NULL, 'fa-solid fa-file-contract', NULL, NULL, 'footer-link', NULL, NULL, NULL, 1, 1, 'en', 'Terms', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(9, 2, NULL, 'Contact', 'contact-us', 'Contact page', 'link', '#', NULL, NULL, 0, 4, 0, NULL, 'fa-solid fa-envelope', NULL, NULL, 'footer-link', NULL, NULL, NULL, 1, 1, 'en', 'Contact', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(10, 3, NULL, 'Dashboard', 'dashboard', 'Admin dashboard', 'link', NULL, 'backend.dashboard', NULL, 0, 0, 0, NULL, 'fa-solid fa-cubes', NULL, NULL, 'nav-link', NULL, '[\"view_backend\"]', NULL, 1, 1, 'en', 'Dashboard', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(11, 3, NULL, 'Notifications', 'notifications', 'System notifications', 'link', NULL, 'backend.notifications.index', NULL, 0, 1, 0, NULL, 'fa-regular fa-bell', NULL, NULL, 'nav-link', NULL, '[\"view_backend\"]', NULL, 1, 1, 'en', 'Notifications', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(12, 3, NULL, 'Menus', 'menus', 'Manage menus and navigation', 'link', NULL, 'backend.menus.index', NULL, 0, 9, 0, NULL, 'fa-solid fa-bars', NULL, NULL, 'nav-link', NULL, '[\"view_menus\"]', NULL, 1, 1, 'en', 'Menus', NULL, NULL, NULL, 'Manage menus and navigation', 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(13, 3, NULL, 'Posts', 'admin-posts', 'Manage posts', 'link', NULL, 'backend.posts.index', NULL, 0, 2, 0, NULL, 'fa-regular fa-file-lines', NULL, NULL, 'nav-link', NULL, '[\"add_posts\",\"delete_posts\",\"restore_posts\",\"restore_roles\"]', '[\"super admin\"]', 1, 1, 'en', 'Posts', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 19:20:07', NULL),
(15, 3, NULL, 'Categories', 'admin-categories', 'Manage categories', 'link', NULL, 'backend.categories.index', NULL, 0, 3, 0, NULL, 'fa-solid fa-diagram-project', NULL, NULL, 'nav-link', NULL, '[\"view_categories\"]', NULL, 1, 1, 'en', 'Categories', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(16, 3, NULL, 'Tags', 'admin-tags', 'Manage tags', 'link', NULL, 'backend.tags.index', NULL, 0, 4, 0, NULL, 'fa-solid fa-tags', NULL, NULL, 'nav-link', NULL, '[\"view_tags\"]', NULL, 1, 1, 'en', 'Tags', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(17, 3, NULL, 'Settings', 'admin-settings', 'System settings', 'link', NULL, 'backend.settings.index', NULL, 0, 5, 0, NULL, 'fa-solid fa-gears', NULL, NULL, 'nav-link', NULL, '[\"edit_settings\"]', NULL, 1, 1, 'en', 'Settings', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(18, 3, NULL, 'Backups', 'admin-backups', 'System backups', 'link', NULL, 'backend.backups.index', NULL, 0, 6, 0, NULL, 'fa-solid fa-box-archive', NULL, NULL, 'nav-link', NULL, '[\"view_backups\"]', NULL, 1, 1, 'en', 'Backups', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(19, 3, NULL, 'Users', 'admin-users', 'Manage users', 'link', NULL, 'backend.users.index', NULL, 0, 7, 0, NULL, 'fa-solid fa-user-group', NULL, NULL, 'nav-link', NULL, '[\"view_users\"]', NULL, 1, 1, 'en', 'Users', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(20, 3, NULL, 'Roles', 'admin-roles', 'Manage roles', 'link', NULL, 'backend.roles.index', NULL, 0, 8, 0, NULL, 'fa-solid fa-user-shield', NULL, NULL, 'nav-link', NULL, '[\"view_roles\"]', NULL, 1, 1, 'en', 'Roles', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(21, 1, 5, 'Action', 'action', 'Example dropdown action', 'link', '/action', NULL, NULL, 0, 0, 1, '5', NULL, NULL, NULL, 'dropdown-item', NULL, NULL, NULL, 1, 1, 'en', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(22, 1, 5, 'Another action', 'another-action', 'Example dropdown action', 'link', '/another-action', NULL, NULL, 0, 1, 1, '5', NULL, NULL, NULL, 'dropdown-item', NULL, NULL, NULL, 1, 1, 'en', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(23, 1, 5, 'Something else here', 'something-else-here', 'Example dropdown action', 'link', '/something-else', NULL, NULL, 0, 2, 1, '5', NULL, NULL, NULL, 'dropdown-item', NULL, NULL, NULL, 1, 1, 'en', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(24, 3, NULL, 'Log Viewer', 'log-viewer', 'View application logs', 'external', '/admin/log-viewer', NULL, NULL, 0, 10, 0, NULL, 'fa-solid fa-file-alt', NULL, NULL, 'nav-link', NULL, '[\"view_logs\"]', NULL, 1, 1, 'en', 'Log Viewer', NULL, NULL, NULL, 'View and search application logs', 1, NULL, NULL, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(25, 3, 13, 'RRDR', 'backendrrdrs', NULL, 'link', NULL, 'backend.rrdrs.index', NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[\"super admin\"]', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2026-04-03 19:03:58', '2026-04-03 19:20:43', '2026-04-03 19:20:43'),
(26, 3, 25, 'test', 'testhdyj', NULL, 'link', NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, '[\"view_roles\"]', '[\"administrator\",\"executive\",\"manager\"]', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2026-04-03 19:07:20', '2026-04-03 19:20:36', '2026-04-03 19:20:36'),
(27, 3, NULL, 'RRDR', 'rrdr', NULL, 'link', NULL, 'backend.rrdrs.index', NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, '[\"view_rrdrs\"]', '[\"super admin\"]', 1, 1, 'en', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, '2026-04-03 19:27:43', '2026-04-03 19:27:43', NULL),
(28, 4, NULL, 'In rerum sed repelle', 'qui-error-aliquam-am', NULL, 'external', NULL, NULL, NULL, 0, 66, 0, NULL, 'Qui ea dolor ea quis', 'Provident aut excep', 'light', 'Odio laboris fugit ', '\" \"', '[\"add_categories\",\"block_users\",\"create_backups\",\"delete_rrdrs\",\"download_backups\",\"edit_tags\",\"restore_posts\",\"restore_rrdrs\",\"restore_tags\",\"view_backend\",\"view_roles\",\"view_rrdrs\"]', '[\"executive\",\"manager\",\"super admin\",\"user\"]', 1, 1, 'en', 'Quos elit animi fa', NULL, NULL, '\" \"', ' ', 1, 1, 1, NULL, '2026-04-03 23:20:37', '2026-04-03 23:22:02', NULL),
(29, 4, NULL, 'Home', 'homef', NULL, 'link', NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, '2026-04-03 23:25:14', '2026-04-03 23:25:14', NULL),
(30, 4, NULL, 'Content', 'content', NULL, 'link', NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, '2026-04-03 23:25:58', '2026-04-03 23:25:58', NULL),
(31, 4, 29, 'About us', 'about-us-', NULL, 'link', NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 'en', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, '2026-04-03 23:27:06', '2026-04-03 23:27:06', NULL),
(32, 4, NULL, 'gfuy', 'gfuy', NULL, 'external', NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, '2026-04-04 00:19:45', '2026-04-04 00:19:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_03_22_233017_add_profile_columns_to_users_table', 1),
(5, '2024_03_23_023114_create_permission_tables', 1),
(6, '2024_03_23_025255_create_media_table', 1),
(7, '2024_03_24_145514_create_settings_table', 1),
(8, '2024_03_24_151236_create_notifications_table', 1),
(9, '2024_03_24_195455_create_user_providers_table', 1),
(10, '2024_03_26_013544_create_activity_log_table', 1),
(11, '2024_03_26_013545_add_event_column_to_activity_log_table', 1),
(12, '2024_03_26_013546_add_batch_uuid_column_to_activity_log_table', 1),
(13, '2024_04_06_020035_create_posts_table', 1),
(14, '2024_04_06_031129_create_categories_table', 1),
(15, '2024_04_06_033820_create_tags_table', 1),
(16, '2024_04_06_154118_create_polymorphic_taggables_table', 1),
(17, '2025_10_03_041046_create_menus_table', 1),
(18, '2025_10_03_041047_create_menu_items_table', 1),
(19, '2026_04_02_120621_create_rrdrs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 4),
(5, 'App\\Models\\User', 5),
(5, 'App\\Models\\User', 6);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(191) NOT NULL,
  `notifiable_type` varchar(191) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view_backend', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(2, 'edit_settings', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(3, 'view_logs', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(4, 'view_users', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(5, 'add_users', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(6, 'edit_users', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(7, 'edit_users_permissions', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(8, 'delete_users', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(9, 'restore_users', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(10, 'block_users', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(11, 'view_roles', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(12, 'add_roles', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(13, 'edit_roles', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(14, 'delete_roles', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(15, 'restore_roles', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(16, 'view_backups', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(17, 'add_backups', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(18, 'create_backups', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(19, 'download_backups', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(20, 'delete_backups', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(21, 'view_posts', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(22, 'add_posts', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(23, 'edit_posts', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(24, 'delete_posts', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(25, 'restore_posts', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(26, 'view_categories', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(27, 'add_categories', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(28, 'edit_categories', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(29, 'delete_categories', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(30, 'restore_categories', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(31, 'view_tags', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(32, 'add_tags', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(33, 'edit_tags', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(34, 'delete_tags', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(35, 'restore_tags', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(36, 'view_comments', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(37, 'add_comments', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(38, 'edit_comments', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(39, 'delete_comments', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(40, 'restore_comments', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(41, 'view_rrdrs', 'web', '2026-04-03 19:25:34', '2026-04-03 19:25:34'),
(42, 'add_rrdrs', 'web', '2026-04-03 19:25:34', '2026-04-03 19:25:34'),
(43, 'edit_rrdrs', 'web', '2026-04-03 19:25:34', '2026-04-03 19:25:34'),
(44, 'delete_rrdrs', 'web', '2026-04-03 19:25:34', '2026-04-03 19:25:34'),
(45, 'restore_rrdrs', 'web', '2026-04-03 19:25:34', '2026-04-03 19:25:34');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `intro` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `type` varchar(191) DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `category_name` varchar(191) DEFAULT NULL,
  `is_featured` int(11) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `meta_title` varchar(191) DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_og_image` varchar(191) DEFAULT NULL,
  `meta_og_url` varchar(191) DEFAULT NULL,
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `order` int(11) DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'Published',
  `moderated_by` int(10) UNSIGNED DEFAULT NULL,
  `moderated_at` datetime DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_by_name` varchar(191) DEFAULT NULL,
  `created_by_alias` varchar(191) DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `name`, `slug`, `intro`, `content`, `type`, `category_id`, `category_name`, `is_featured`, `image`, `meta_title`, `meta_keywords`, `meta_description`, `meta_og_image`, `meta_og_url`, `hits`, `order`, `status`, `moderated_by`, `moderated_at`, `created_by`, `created_by_name`, `created_by_alias`, `updated_by`, `deleted_by`, `published_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Deleniti sit et autem', 'deleniti-sit-et-autem', 'Sunt fuga itaque eum possimus inventore et ab. Vitae quibusdam accusamus nulla quaerat molestiae veritatis omnis velit. Consequatur aperiam ut ullam blanditiis ducimus eligendi.', 'Porro quas sunt omnis dolores quo assumenda maxime. Assumenda consequatur id similique pariatur est quia. Culpa saepe magni omnis praesentium quo commodi aspernatur temporibus. Commodi facere harum consectetur qui sapiente.\n\nLaborum qui excepturi eum quia nulla nostrum. Iste qui neque et consequatur. Debitis qui qui quaerat voluptatem ut nulla illo. Ad molestiae repellendus voluptate placeat sint modi libero.\n\nOfficia reprehenderit voluptas ut et at sed. Beatae voluptate sed et sit. Aut eius laboriosam blanditiis cum numquam sit repudiandae. Ea quod mollitia inventore ipsum laboriosam explicabo perspiciatis.\n\nProvident vero molestiae sed praesentium molestias quo. Doloremque omnis et nihil et repellat. Enim nostrum quia unde eum aliquid et. Ea iure aut eos optio quas culpa dolor voluptas. Officia porro sunt libero ea vero ullam rerum.\n\nQuisquam labore nulla esse iusto est et. Qui ut natus ad fugiat. Ut suscipit voluptates earum ut quia minus.\n\nDicta veritatis dolorem est nisi illo. Qui distinctio eveniet laborum. Soluta reprehenderit occaecati enim cumque.', 'Feature', 2, NULL, 1, 'https://picsum.photos/1200/630?random=38', '', '', '', '', '', 0, NULL, 'Unpublished', NULL, NULL, 1, 'Super Admin', NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(2, 'Rerum qui repellendus aut', 'rerum-qui-repellendus-aut', 'Qui sit laboriosam nisi placeat tenetur rerum. Earum commodi ad cumque sunt sint quisquam et. Sit aut totam sapiente dolor veritatis impedit maxime est. Asperiores amet corrupti aut facilis rem.', 'Eaque et alias maxime non illum. Suscipit eveniet temporibus placeat eius quisquam vero unde. Quae recusandae voluptatibus sunt officiis molestias. Dolore illo velit incidunt.\n\nInventore aut soluta nulla qui aut. Tempore possimus reiciendis unde itaque enim voluptas. Aut dicta dolor id ex.\n\nUnde enim sint harum odit fugiat non qui. Enim id maxime animi voluptatem velit. Eos aperiam ea necessitatibus incidunt quia accusamus. Quos dolorum quia non error excepturi et iusto.\n\nOmnis quia illum sapiente ut. Consectetur nesciunt qui libero veritatis sit magnam. Quasi quidem dolores modi autem sint. Repudiandae dolorum amet id.\n\nQuidem vel iure autem enim voluptatibus et aut soluta. Eveniet cupiditate explicabo laboriosam perferendis autem at consequatur. Distinctio veniam cupiditate dignissimos laborum magnam. Sequi et ipsum magnam aliquam ipsa.', 'News', 4, NULL, 1, 'https://picsum.photos/1200/630?random=3', '', '', '', '', '', 0, NULL, 'Published', NULL, NULL, 1, 'Super Admin', NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(3, 'Temporibus ut ab qui soluta', 'temporibus-ut-ab-qui-soluta', 'Accusamus provident quos architecto et dignissimos praesentium suscipit laboriosam. Modi quo tempore aut dicta.', 'Quae explicabo ut aut ex. Qui tenetur iure repudiandae laborum. Perspiciatis sed quibusdam quia dignissimos sunt fugiat. Provident nam eveniet esse sunt et voluptatem a. Alias suscipit vel et quod.\n\nDolorum autem voluptatem repellat dolore sed et. Nihil architecto inventore quaerat quis aut neque facilis. Expedita nihil inventore rerum ut.\n\nAut ea voluptates temporibus culpa. Quaerat recusandae necessitatibus itaque iusto repellat non aliquid.\n\nItaque magni inventore magnam asperiores. Doloremque repellat ut natus eos impedit qui et. Est omnis molestiae provident qui iusto.\n\nEum velit labore quam placeat dolores eveniet at nihil. Unde impedit ut aperiam sit.\n\nQuasi provident deleniti quia nostrum facere. Eos iusto explicabo magni nobis ducimus. Qui placeat voluptates incidunt.', 'News', 5, NULL, 1, 'https://picsum.photos/1200/630?random=35', '', '', '', '', '', 0, NULL, 'Unpublished', NULL, NULL, 1, 'Super Admin', NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(4, 'Unde nemo qui eum odio eaque', 'unde-nemo-qui-eum-odio-eaque', 'Sint aut et et pariatur. Sed eveniet aperiam culpa assumenda mollitia. Cumque dolores qui corrupti eligendi.', 'Vel eum ullam et non facere. Nostrum earum harum occaecati odit enim animi tenetur. Adipisci est qui eligendi omnis earum eum inventore. Doloremque corporis quis ea qui et.\n\nRepellendus unde consequatur eum consequatur eos eos voluptatem. Vero veniam repudiandae dicta dignissimos rerum. Eum doloremque repellendus doloribus sit quidem. Voluptatem necessitatibus maiores voluptatem doloribus.\n\nSit optio suscipit error sint aperiam iusto laboriosam. Minus fuga molestiae facere rem excepturi. Iure omnis laudantium molestias neque expedita molestiae facilis delectus. Sed autem nulla nisi adipisci aut rerum sunt neque.\n\nVoluptatem harum ut est excepturi. Asperiores aut voluptatibus eaque asperiores consequatur dolorum. Praesentium laboriosam eligendi omnis blanditiis.\n\nDolor et impedit tempore commodi nostrum sit. Consequatur et sit aliquid accusamus ut. Cupiditate repellendus vel vel velit vel dolores. Voluptas molestias aspernatur neque nesciunt et neque consequatur aliquam.\n\nQuasi harum odit tempore quaerat quis qui sequi. Numquam laborum vitae perspiciatis ad id ex.\n\nQui dolor laudantium deserunt doloribus. Debitis aut consequuntur molestiae deserunt voluptatem voluptatum qui. A exercitationem dolorem est sit officiis aut excepturi. Fuga nemo qui vitae sequi rerum.', 'Feature', 1, NULL, 1, 'https://picsum.photos/1200/630?random=23', '', '', '', '', '', 0, NULL, 'Unpublished', NULL, NULL, 1, 'Super Admin', NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(5, 'Qui ea temporibus officiis', 'qui-ea-temporibus-officiis', 'Cumque labore incidunt optio cumque nam ab sequi. Quia deleniti esse rerum eum aperiam rerum velit.', 'Rem inventore inventore fuga culpa nisi in neque. Aliquam sit deserunt dolorum voluptatem consectetur consectetur ut.\n\nQuas ut fugiat ipsam aut et et. At dolores sed sed earum omnis.\n\nIn ut qui eos consequatur tenetur quis iure. Vel non aspernatur consequuntur qui dignissimos.\n\nFacere id odio totam sed quos tempora sed. Voluptatum occaecati quasi nemo doloremque necessitatibus deleniti hic. Officia minus architecto modi quaerat minus explicabo veniam.\n\nDebitis sapiente quis quia voluptas rem quas omnis nihil. Et sunt excepturi aliquid minus ex. Ratione nam tempora et quasi voluptas quia.\n\nEst voluptatem quidem nihil minus. Soluta dolorem iusto id optio voluptatem natus. Blanditiis eaque rerum eum asperiores.\n\nUt in eum est maiores. Quidem beatae quasi beatae qui earum laboriosam corrupti. Ea et rerum iste praesentium unde.', 'Article', 3, NULL, 0, 'https://picsum.photos/1200/630?random=45', '', '', '', '', '', 0, NULL, 'Published', NULL, NULL, 1, 'Super Admin', NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(6, 'In dolores quas quisquam et', 'in-dolores-quas-quisquam-et', 'Cum excepturi repellat aut. Ut id aperiam iste. Laboriosam pariatur sapiente reiciendis eos sed a necessitatibus sunt. Optio ut animi praesentium quia.', 'Fuga dolorem voluptatum quasi animi dolor. Totam praesentium et similique molestiae ut. Perspiciatis dolores reprehenderit dolores architecto et mollitia quisquam. Deserunt magni animi quia et inventore.\n\nEt minus autem earum animi ex dolor. Totam fuga temporibus omnis quidem voluptas ipsa quo. Est consequatur minus placeat voluptatem alias.\n\nEx omnis rerum ex eos incidunt. Voluptatem aut neque suscipit velit vel.\n\nEveniet voluptatem id perferendis voluptatibus aut voluptatem. At animi magni explicabo qui saepe. Consectetur nihil magni quasi dignissimos consequatur aliquid quisquam tempore. Vero est modi aut ipsa.\n\nTempora suscipit sapiente voluptatum est enim perspiciatis. Iure totam non quasi fuga qui. Dolor quia sint sit voluptatem voluptatem qui cupiditate. Officia in ipsam dicta cum.\n\nNulla hic architecto consequatur architecto voluptas dolore aperiam. Molestias qui quae voluptatem. Esse tenetur ea non et nihil est et. Delectus et aut amet et. Tenetur modi sint deleniti odio quasi.', 'Article', 3, NULL, 0, 'https://picsum.photos/1200/630?random=48', '', '', '', '', '', 0, NULL, 'Unpublished', NULL, NULL, 1, 'Super Admin', NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(7, 'Nihil in quia cumque eveniet', 'nihil-in-quia-cumque-eveniet', 'Qui nisi asperiores quia cumque rerum. Mollitia qui voluptatem et quia ipsum consequuntur quibusdam.', 'Voluptas odio id blanditiis distinctio blanditiis eligendi voluptatem sed. Ea repellat a qui dolor excepturi.\n\nSit omnis dolorem non enim ipsum maxime accusantium. Iusto quia architecto adipisci commodi provident. Eligendi sapiente error quis repellendus sed et.\n\nIure et quidem est doloribus sint laborum. Ut incidunt laborum corporis rerum asperiores aut et. Delectus voluptas sit ea provident corporis et facilis.\n\nAdipisci deserunt molestiae alias ea provident numquam assumenda tempore. Modi est quos consequatur ea voluptate eaque eveniet. Odit repellendus aperiam dolores ipsum.\n\nQuas rerum et sed ratione incidunt alias. Et recusandae ut et doloribus rem dolorum. Quis libero voluptatibus quibusdam nesciunt.\n\nQuaerat dolore dolor sit ea illo aut. Cum ea reprehenderit saepe. Qui recusandae est dolorem aliquid.\n\nId voluptatum velit voluptatem ad eveniet dolores. Nihil incidunt sequi et officiis harum. Reiciendis cupiditate dignissimos porro quas est. Dolores dolores cum odit. Et molestiae quae quas praesentium voluptatibus.', 'Feature', 3, NULL, 1, 'https://picsum.photos/1200/630?random=34', '', '', '', '', '', 0, NULL, 'Published', NULL, NULL, 1, 'Super Admin', NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(8, 'Dolorem odio ut voluptatem', 'dolorem-odio-ut-voluptatem', 'Ut omnis enim consequatur velit quaerat quis. At similique officia vel similique harum. Voluptas odio velit et unde unde consequatur. Autem accusamus consequatur porro quam porro non praesentium. Eum quia rerum nemo sint id consequatur.', 'Aliquam dolores nihil debitis reprehenderit. Facilis ullam aut dolorum consequatur nesciunt velit. Natus dolores laudantium rerum nulla quas maxime voluptatem. Reprehenderit soluta quasi sed commodi unde asperiores et.\n\nVoluptas doloremque dolores autem impedit. Molestiae et esse ad cumque itaque. Et illum natus aut fuga.\n\nPariatur magni est aliquam dolores cumque sit repellendus. Tempora eveniet laborum illum distinctio quia id dolores. Nesciunt ut rem modi illo error. Pariatur reiciendis temporibus vel eius ullam eum dolores. Nihil aut explicabo rem esse porro.\n\nDolor laborum impedit nobis. Maiores dolore qui rerum laudantium dolor. Magni fugiat repudiandae rerum corrupti veniam et. Ut ullam et totam est fuga. Repudiandae ipsum porro nobis sed rerum quod perspiciatis consequatur.\n\nMolestias vel deserunt est assumenda omnis numquam deleniti. Aut et velit et doloribus laudantium tenetur impedit mollitia. Aut sunt error perferendis placeat exercitationem non perspiciatis. Dignissimos officiis eligendi sit atque et aut.\n\nMagnam necessitatibus quia sed quis ut autem. Ratione id voluptates enim. Et quos autem et eum repudiandae et ut.', 'News', 2, NULL, 1, 'https://picsum.photos/1200/630?random=12', '', '', '', '', '', 0, NULL, 'Draft', NULL, NULL, 1, 'Super Admin', NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(9, 'Expedita sed et recusandae', 'expedita-sed-et-recusandae', 'Qui autem inventore delectus sunt vero nostrum. Voluptatem est libero facere dignissimos. Officia exercitationem voluptatem delectus velit voluptatem commodi distinctio.', 'Eos unde architecto minus veniam velit ex dolore. Tempore similique aut quisquam et neque quisquam. Doloremque quasi ipsa repellat.\n\nAsperiores ullam maxime tempore aut. Repudiandae quo et eos qui ea rerum. Maxime et eos magni in blanditiis possimus.\n\nQuia excepturi eaque exercitationem quam quasi porro. Ea vel ut qui vero debitis animi tenetur. Praesentium et esse non.\n\nNam eius in nobis consequuntur autem fugit alias quia. Sit vel voluptatem iusto omnis sint. Eligendi aut eligendi rerum eos. Similique et vero molestiae quidem ratione excepturi.\n\nIusto est in nostrum et deleniti dolorum ipsa incidunt. Neque nesciunt voluptatem labore sint aperiam. Voluptatem iste rerum voluptas impedit molestiae quos. Veniam quam autem accusamus neque voluptas nihil officia. Veritatis molestias perspiciatis sed esse inventore et aut et.\n\nSed quis sint veniam quisquam. Atque eligendi alias deleniti in non tempora.\n\nTenetur distinctio voluptate iure vel tempore. Quos sapiente architecto ducimus amet et aut. Ut laboriosam sapiente sint molestiae eos quos.', 'Article', 3, NULL, 1, 'https://picsum.photos/1200/630?random=32', '', '', '', '', '', 0, NULL, 'Published', NULL, NULL, 1, 'Super Admin', NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(10, 'Et possimus aut harum', 'et-possimus-aut-harum', 'Aut quia quidem ipsam tenetur quis vel provident. Aliquam cupiditate illo mollitia impedit et tenetur facere.', 'Et laudantium at nemo minus soluta magnam. Magni ut et deleniti consequatur sed. Ipsa deleniti totam odio facere et.\n\nSapiente praesentium sint ipsa quisquam aut repudiandae laborum. Molestias sed libero perspiciatis quas beatae. Voluptas vitae atque fuga nihil delectus asperiores. Fugiat expedita facere expedita.\n\nModi est ex libero blanditiis deleniti consequuntur dolor. Consequuntur in laborum quia magni officia ex qui. Culpa ratione aut et ipsam pariatur. Ipsum accusamus maxime temporibus quibusdam animi aspernatur.\n\nUnde quisquam illum commodi optio. Officia ipsa debitis ipsam debitis. Ducimus qui quia est.\n\nMollitia doloribus suscipit aut hic voluptatem repudiandae. Est fugiat in corrupti libero officiis laboriosam fugiat harum. Dolorem adipisci consectetur nostrum et omnis.\n\nReprehenderit fugiat reprehenderit repellat quas voluptatem. Temporibus doloribus dolores cumque ratione et sequi. Eum est tempore quod ipsum veniam. Adipisci labore quas eum recusandae.', 'Feature', 2, NULL, 1, 'https://picsum.photos/1200/630?random=46', '', '', '', '', '', 0, NULL, 'Published', NULL, NULL, 1, 'Super Admin', NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(11, 'Animi id qui eveniet', 'animi-id-qui-eveniet', 'Velit et et aliquam unde in. Natus aperiam ad sed commodi enim repudiandae incidunt quaerat. Libero consequuntur et sit dolorem voluptatum provident pariatur.', 'Molestiae vitae voluptatem itaque consequatur quas earum. Voluptatem numquam sunt id et.\n\nUt maxime perferendis laborum qui dolor. Rem ratione libero nam et eum et et. Sequi voluptatem nobis earum iste cum labore. Provident occaecati optio impedit eligendi aut molestias consequatur.\n\nEligendi id commodi quod ratione quibusdam corporis. Numquam voluptas laborum dicta id a impedit.\n\nOmnis non et ullam dignissimos. Ut sunt doloremque et hic aut et. Consequatur tempore commodi in ut id voluptas quis.\n\nTenetur eveniet libero in non officiis. Quos quis natus animi nihil aperiam. Excepturi in possimus totam laboriosam in iure. Quis officia officia nobis distinctio sed.\n\nEt quia et adipisci sapiente. Quia et ea blanditiis nulla sunt modi quas. Non placeat enim optio animi architecto. Mollitia ratione est dolor ullam expedita odit.', 'News', 4, NULL, 1, 'https://picsum.photos/1200/630?random=22', '', '', '', '', '', 0, NULL, 'Draft', NULL, NULL, 1, 'Super Admin', NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(12, 'Assumenda est illo maxime', 'assumenda-est-illo-maxime', 'Ut tenetur cupiditate et at iure qui quo. Enim deserunt tempore sequi soluta. Reiciendis quia ut qui eveniet ab pariatur tempora voluptas. Iusto porro qui ex facere quo est.', 'Itaque rerum voluptate fuga dolore laboriosam cum suscipit. Quod facere laudantium laudantium animi. In pariatur est ut quas commodi ut recusandae eaque. Deleniti tenetur dolores et nisi sit illum et nobis.\n\nSuscipit distinctio magnam alias et quisquam in. Laudantium consequatur ratione minima beatae sit eum. Tempora tempore eveniet quia laboriosam. Sapiente sint delectus et totam excepturi commodi labore.\n\nPlaceat sint et sed. Tempora debitis impedit consequatur quos ut beatae dolorem deserunt.\n\nEt provident neque sunt et. Aut assumenda et rerum non incidunt. Iure et amet ad blanditiis. Necessitatibus et consequatur quo id optio vitae ipsa.\n\nCorrupti quia voluptatem cum accusantium voluptas et. Laudantium nesciunt itaque veniam minus tempora quaerat. Quis et aut omnis ea soluta dignissimos.\n\nEsse libero at officia distinctio nulla quidem et. Maxime veniam harum ea est molestiae illo nemo quas. Exercitationem illum quia rerum velit.\n\nTenetur molestiae soluta necessitatibus deserunt. Omnis quos harum qui distinctio repellat consequatur ut. Dolores facilis mollitia aut. Accusantium saepe voluptatum perspiciatis dignissimos sit qui dolores beatae.', 'News', 5, NULL, 0, 'https://picsum.photos/1200/630?random=46', '', '', '', '', '', 0, NULL, 'Draft', NULL, NULL, 1, 'Super Admin', NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(13, 'Odio saepe est recusandae', 'odio-saepe-est-recusandae', 'Vitae consectetur quibusdam quae sit. Neque iusto eveniet dolore nihil aliquid. Voluptatibus nam voluptatem iusto at. Dolore eum harum explicabo deserunt vel quo.', 'Non adipisci fuga autem ipsam praesentium numquam nihil. In rerum voluptatem nihil veritatis molestiae perferendis. Neque natus quo aut quis. Dolorem sunt mollitia provident maxime.\n\nExpedita quia eum quasi praesentium. Ea quis dicta voluptas quaerat. Temporibus consequuntur beatae eos veritatis vitae corrupti.\n\nOptio soluta suscipit reprehenderit. Sequi sit illum molestiae. Qui sint illo voluptatibus rerum.\n\nIn tempora in et quo. Repellendus pariatur qui magnam.\n\nOptio aliquid commodi expedita impedit dolorem vero quis est. Autem perferendis voluptas quibusdam laboriosam aliquid quia et. Hic consequatur sequi quas ut recusandae. Placeat nulla qui eligendi porro eos odit at ullam. Et aliquam at illum ea magnam.\n\nOfficiis omnis est et suscipit ipsa optio dignissimos. Cum sequi ex et ipsam nobis consequatur. Architecto doloremque sed facere velit tempore ipsa voluptatem. A molestiae commodi et dolor ut natus cumque.\n\nRecusandae eaque consequatur omnis. Molestiae et earum voluptatibus dolor consequatur quos.', 'Article', 3, NULL, 0, 'https://picsum.photos/1200/630?random=13', '', '', '', '', '', 0, NULL, 'Unpublished', NULL, NULL, 1, 'Super Admin', NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(14, 'Hic non recusandae et qui', 'hic-non-recusandae-et-qui', 'Reiciendis natus eum error corporis sed. Sequi quaerat dolorem tempora eveniet.', 'Odit molestias quod quo soluta ut ea. Illum aut corporis illum doloremque. Tempora similique facilis et veniam perspiciatis. Nihil impedit eaque aut et officia.\n\nMagnam et quae maiores aut voluptates fugit molestiae quam. Ut suscipit id eius doloribus veniam. Voluptatem repellendus aut quos numquam.\n\nAperiam quis voluptas voluptatem et voluptas cumque repellat. Commodi perferendis voluptatem fugiat rerum. Qui magni quia exercitationem ut quo enim. Quibusdam voluptas porro sint eius ea sint.\n\nOfficia ut sed similique vero laboriosam. Assumenda ea blanditiis hic sunt alias nemo commodi. Praesentium consequatur atque beatae ipsa aspernatur vero.\n\nId hic consequatur earum et facere unde molestias nisi. Voluptatem incidunt reiciendis cumque. Et et suscipit vero voluptatibus.\n\nAutem rerum tempore aliquid quo soluta temporibus. Sunt aut rem sed. Distinctio aut autem laudantium corrupti veritatis pariatur inventore.', 'Feature', 3, NULL, 1, 'https://picsum.photos/1200/630?random=25', '', '', '', '', '', 0, NULL, 'Published', NULL, NULL, 1, 'Super Admin', NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(15, 'Iste modi sit officia et ut', 'iste-modi-sit-officia-et-ut', 'Omnis ab natus est tempora rerum quis accusamus. Commodi repellendus quis molestiae explicabo et placeat est iste. Ut et sed harum ea dolore blanditiis.', 'Aspernatur in rerum omnis quisquam. Facere vitae amet aut omnis dolores magnam quidem. Quas temporibus est quod dolorem et quis tenetur.\n\nSed asperiores consequatur modi totam et. Totam accusamus omnis similique perspiciatis minima. Consequatur voluptatem dolor vitae et exercitationem voluptas reiciendis. Et non aut beatae harum consequatur. Aut vitae ea deserunt atque nam eveniet.\n\nQuibusdam deleniti reprehenderit nulla. Voluptatem voluptatibus et sit qui. Ipsam in vel et assumenda minima cupiditate laborum.\n\nIure veritatis nulla optio ipsum minus magni aut. Vel laudantium dicta alias autem deleniti. Quidem iste quis nesciunt dicta nostrum laboriosam. Et sed consequatur voluptatibus veritatis doloribus quae. Id dolorum eligendi et.\n\nEt quas facilis libero a qui reprehenderit. Ut voluptatem et excepturi aut omnis eligendi ut. Facere nesciunt sapiente nemo in repellat culpa quam.', 'News', 5, NULL, 1, 'https://picsum.photos/1200/630?random=43', '', '', '', '', '', 0, NULL, 'Published', NULL, NULL, 1, 'Super Admin', NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(16, 'Et ullam iste quas', 'et-ullam-iste-quas', 'Eveniet animi deserunt veritatis cumque. Eius sed voluptatum quisquam cumque adipisci. Laboriosam ut magnam voluptatibus modi eligendi. Animi praesentium occaecati sed porro dolorum magni voluptatibus. Blanditiis tenetur at aliquid quas totam.', 'Commodi mollitia reprehenderit alias quia eum et. Quia molestias voluptas consequatur molestiae nam. Laboriosam qui sunt consectetur. Et odit velit voluptatem sapiente.\n\nQui deleniti voluptate sint laboriosam aut. Cupiditate quia quasi voluptatem facilis aut. Qui possimus aut ex accusamus fuga est.\n\nExercitationem consequatur rerum sed libero debitis. Consequatur harum culpa aut incidunt harum dolores occaecati. Autem qui omnis distinctio vero eligendi illum. Hic nobis autem nobis repellendus voluptatem dolore aut.\n\nQuam deleniti et consequatur et ducimus. Ipsa porro sint officiis. Nobis sunt reiciendis aspernatur quis. Quia ut nemo deleniti et ea ea.\n\nPerferendis et dolor recusandae voluptate a libero. Ut ipsa rerum maiores. Aut aut quidem recusandae aut praesentium laboriosam facere.', 'News', 4, NULL, 1, 'https://picsum.photos/1200/630?random=35', '', '', '', '', '', 0, NULL, 'Draft', NULL, NULL, 1, 'Super Admin', NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(17, 'Et qui mollitia impedit quia', 'et-qui-mollitia-impedit-quia', 'Libero quaerat vitae est alias. Explicabo sapiente saepe debitis quo sed eos. Vitae animi enim excepturi incidunt voluptas. Non expedita non est architecto necessitatibus asperiores dolor.', 'Hic quam debitis placeat repellat magni. Sunt occaecati nemo numquam deleniti vero sit. Nemo eius quo quasi veritatis. Blanditiis accusamus ab modi in consequatur vel velit.\n\nPossimus tempora dolor rem eum facilis dolores. Voluptas odit rerum laborum natus autem veniam facilis eveniet. Nobis commodi sequi distinctio. Qui eum et esse adipisci dicta est voluptatem. Error tenetur quia eveniet temporibus placeat.\n\nQui culpa eos voluptatem ipsam error pariatur. Dolor nihil corrupti aut laudantium quasi. Consequatur error aut velit et consequatur. Ut placeat quod nulla dolores.\n\nIn quis ea cupiditate ut eaque accusamus. Culpa accusantium et possimus rerum fuga saepe suscipit. Ex voluptatum omnis iure qui. Impedit nostrum non eveniet eos.\n\nAut vel nobis ut qui nisi sapiente. Expedita aperiam fugiat voluptatem eligendi vel.', 'Feature', 2, NULL, 1, 'https://picsum.photos/1200/630?random=26', '', '', '', '', '', 0, NULL, 'Published', NULL, NULL, 1, 'Super Admin', NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(18, 'Dolorum esse quis a', 'dolorum-esse-quis-a', 'Necessitatibus consequatur cum quibusdam tempora vel. Et cum soluta ab atque quasi sed doloremque. Impedit similique cupiditate pariatur qui rem quae.', 'Qui placeat error ab et fugiat voluptates qui id. Eligendi nisi excepturi aut provident est explicabo est molestiae. Aut optio rerum est occaecati ea repellendus molestiae.\n\nNecessitatibus possimus et a amet omnis doloribus. Itaque distinctio ratione veniam qui. Nobis alias sequi omnis eos ea quia.\n\nExercitationem necessitatibus incidunt suscipit minus magnam. Amet magnam facere itaque aut facilis alias. Beatae qui corporis in. Est voluptatem impedit est autem magnam.\n\nBeatae et nihil unde ipsum fugiat a repellendus saepe. Aperiam sapiente velit qui rem quasi voluptatibus. Et est excepturi autem fugiat sit animi. Nesciunt ipsa natus et quia voluptatem ut libero exercitationem.\n\nQuis accusantium repellat a facilis sequi tenetur similique id. Mollitia voluptatem distinctio est.', 'Article', 1, NULL, 0, 'https://picsum.photos/1200/630?random=1', '', '', '', '', '', 0, NULL, 'Draft', NULL, NULL, 1, 'Super Admin', NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(19, 'Voluptas dolor rerum unde', 'voluptas-dolor-rerum-unde', 'Eligendi molestiae quidem quis atque aut debitis veniam. Vel laboriosam facere repellendus repellat officiis quia eaque inventore. Maiores sunt a fuga tenetur.', 'Aspernatur est iste quas. Sed saepe officiis sit ut ullam saepe odit voluptates. Dolor fugit sit officiis et adipisci doloremque harum. Modi minus hic consequatur voluptatum excepturi hic.\n\nUt labore minima maiores ratione nobis. Nam ad voluptas autem aut error dolorem. Neque voluptas velit deserunt porro dolorum rerum est.\n\nRem assumenda omnis quo pariatur. Non cumque similique animi sint aut odio deleniti cumque. Recusandae quisquam iste perspiciatis tempora adipisci corporis.\n\nMolestiae iusto id enim omnis id molestiae adipisci. Dolorem quia placeat voluptas modi non quia provident adipisci. Et temporibus qui dolore sint ipsa nihil eius. Et voluptatem voluptatem sed porro quae quos saepe sint.\n\nAnimi et et inventore exercitationem asperiores asperiores laudantium. Magni sit nemo ut esse. Est laudantium amet est dolor dolores officiis in. Doloribus optio totam iure fugiat eum est omnis.\n\nMaxime sit quos quia rem et perferendis animi. Quo et suscipit repellat fugiat. Et dolor iusto minima. Placeat aut dolor voluptatibus laudantium.\n\nUt pariatur consequatur magnam aut ex maiores. Laudantium eaque ut quos iusto ea id. Reprehenderit iure accusamus a esse molestias voluptates temporibus.', 'Article', 2, NULL, 0, 'https://picsum.photos/1200/630?random=42', '', '', '', '', '', 0, NULL, 'Unpublished', NULL, NULL, 1, 'Super Admin', NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(20, 'Qui vitae adipisci aut', 'qui-vitae-adipisci-aut', 'Facere dolore iste qui repellat eum molestiae laboriosam. Quasi vel cupiditate non est. Ut illum ipsa ullam et.', 'Nemo cum cumque eius perferendis veritatis. Vero quod quae expedita neque saepe voluptatem vel.\n\nEt ab non eveniet reprehenderit ut illum. Cupiditate rem vitae dolorem quasi excepturi. Velit id harum eligendi fugit omnis reiciendis et. Sed molestiae odit reprehenderit beatae atque et.\n\nDolor perferendis alias cum commodi voluptas id. Vel et numquam minus deserunt quisquam qui. Officiis est sed sed enim consequatur impedit consequatur. Quia ea sapiente labore laboriosam magni voluptatum.\n\nFuga exercitationem perferendis sapiente praesentium. Esse sed deleniti officiis vitae harum dignissimos aut nihil. Soluta laboriosam et et est qui in. Placeat enim asperiores perferendis fugit saepe corrupti.\n\nIpsa ullam dignissimos doloremque incidunt autem est. Eos magnam esse sed fuga consequatur. Distinctio nostrum sed et accusamus aliquid dolore consectetur. Ipsa dolores voluptatibus hic molestias.\n\nMolestias odio est consequatur velit sed aliquid. Eum animi cum deleniti ipsa. Ab iure laboriosam laudantium omnis qui blanditiis. Necessitatibus ipsa est libero velit at officia vel.', 'Article', 5, NULL, 0, 'https://picsum.photos/1200/630?random=6', '', '', '', '', '', 0, NULL, 'Published', NULL, NULL, 1, 'Super Admin', NULL, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super admin', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(2, 'administrator', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(3, 'manager', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(4, 'executive', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50'),
(5, 'user', 'web', '2026-04-03 18:24:50', '2026-04-03 18:24:50');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 2),
(21, 5),
(22, 5),
(42, 5);

-- --------------------------------------------------------

--
-- Table structure for table `rrdrs`
--

CREATE TABLE `rrdrs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `val` text DEFAULT NULL,
  `type` char(20) NOT NULL DEFAULT 'string',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taggables`
--

CREATE TABLE `taggables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `taggable_id` bigint(20) UNSIGNED NOT NULL,
  `taggable_type` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `group_name` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'Active',
  `meta_title` varchar(191) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `slug`, `group_name`, `description`, `image`, `status`, `meta_title`, `meta_description`, `meta_keyword`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Omnis', 'omnis', NULL, 'Sunt dolores voluptatibus vero blanditiis nisi. Ut neque occaecati tenetur ducimus provident quam consequatur iusto. Velit sapiente quos maiores rerum eum. Voluptates dolore ratione sequi culpa natus labore.', NULL, 'Draft', NULL, NULL, NULL, 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(2, 'Et optio', 'et-optio', NULL, 'Labore voluptatem eaque rerum sapiente et. Sed praesentium consequuntur qui reprehenderit id accusamus nemo. Iure minima dolorem ad neque velit dolorum sunt. Est molestiae ea atque est.', NULL, 'Active', NULL, NULL, NULL, 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(3, 'Quis tempore', 'quis-tempore', NULL, 'Molestiae praesentium quo nisi aut culpa. Quia modi officia deserunt sint vel distinctio consectetur. Quas qui voluptatem tenetur rem vel. Sint vero illo nihil facilis voluptatem id.', NULL, 'Draft', NULL, NULL, NULL, 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(4, 'Accusamus', 'accusamus', NULL, 'Facilis qui qui ipsum sed est qui consequuntur minima. Velit quod nostrum et incidunt voluptatem aut beatae quo. Ad tenetur odio ut deserunt omnis explicabo. Nemo adipisci adipisci amet.', NULL, 'Inactive', NULL, NULL, NULL, 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(5, 'Et dolores', 'et-dolores', NULL, 'Dolore similique cupiditate est debitis quos et inventore. Vel libero dolores adipisci exercitationem qui est. Sit ea recusandae beatae deserunt.', NULL, 'Active', NULL, NULL, NULL, 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(6, 'Odit et', 'odit-et', NULL, 'Dignissimos laboriosam blanditiis vitae error aut. Qui hic delectus nobis omnis est velit. Optio fugiat et rerum debitis ut expedita dolores. Velit consequatur eligendi earum aut inventore ut at. Ut est nisi nam est reprehenderit aperiam.', NULL, 'Inactive', NULL, NULL, NULL, 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(7, 'Doloremque', 'doloremque', NULL, 'Quod ipsam harum placeat omnis commodi. Non quae eum maxime rerum molestiae tenetur et. Placeat beatae fugiat doloremque qui eos eos. Officiis praesentium voluptas rerum impedit unde aut. Quia corrupti officiis sed.', NULL, 'Draft', NULL, NULL, NULL, 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(8, 'Qui et omnis', 'qui-et-omnis', NULL, 'Ea harum exercitationem et et est. Aut voluptas qui error esse. Enim sit voluptatum quas harum. Quia magnam iusto tempora voluptas non voluptatem inventore rerum.', NULL, 'Active', NULL, NULL, NULL, 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(9, 'Molestiae', 'molestiae', NULL, 'Tenetur numquam aliquid voluptatum voluptas ut dolorem qui nam. Vitae veniam vel repudiandae id accusantium et dolor. Quo itaque aut ipsa nisi consequatur vel. Quos non ut molestias pariatur est sint nulla.', NULL, 'Inactive', NULL, NULL, NULL, 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(10, 'Dolor dolorum', 'dolor-dolorum', NULL, 'Maxime consectetur et facilis cupiditate fugit quae minima. Nihil sunt velit consequuntur quasi architecto optio. Culpa aut voluptatum similique recusandae. Error nesciunt beatae expedita facilis neque est et.', NULL, 'Draft', NULL, NULL, NULL, 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(11, 'Quia molestiae', 'quia-molestiae', NULL, 'Accusamus a est ut nulla beatae aperiam pariatur. Esse nihil et unde iste voluptate. Quidem quod sit deleniti magni. Harum nostrum dicta aut culpa sapiente. Assumenda sunt dignissimos consequuntur eaque.', NULL, 'Active', NULL, NULL, NULL, 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(12, 'Sit sapiente', 'sit-sapiente', NULL, 'Vero odit nihil eos autem aut maiores. Blanditiis magni dolor aliquid officiis qui. Ullam laborum eum alias porro sed ut dignissimos.', NULL, 'Active', NULL, NULL, NULL, 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(13, 'Est laboriosam', 'est-laboriosam', NULL, 'Vero beatae veritatis ut eius. Aut nobis in exercitationem enim mollitia inventore. Nulla alias quo doloremque aperiam voluptatem cumque. Iure voluptas et amet praesentium.', NULL, 'Inactive', NULL, NULL, NULL, 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(14, 'Et hic omnis', 'et-hic-omnis', NULL, 'Consequuntur ea sint qui laboriosam. In enim officiis non. Magnam sit consequuntur quos recusandae laudantium ut tempora. Enim magni incidunt est exercitationem voluptatem. Ab suscipit velit accusamus cupiditate et in distinctio.', NULL, 'Inactive', NULL, NULL, NULL, 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(15, 'Ut laborum', 'ut-laborum', NULL, 'Id aut quisquam ipsa est. Ipsa ducimus ipsum molestiae pariatur. Quia debitis blanditiis eaque beatae. Incidunt autem et delectus voluptatum iure omnis ut. Nihil voluptates perspiciatis illum repudiandae.', NULL, 'Active', NULL, NULL, NULL, 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(16, 'Exercitationem', 'exercitationem', NULL, 'Voluptas eius vel veritatis est quae consequatur. Quo veritatis dignissimos sed ipsa odio laborum quisquam sunt. Perspiciatis et aut sit atque labore. Minima voluptatum dolorum doloribus velit.', NULL, 'Draft', NULL, NULL, NULL, 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(17, 'Quae et', 'quae-et', NULL, 'Quia nihil aperiam eius qui delectus. Vitae voluptates molestiae corrupti aliquam. Nobis quaerat nemo voluptatem repellendus. Sed esse ut non eaque sit.', NULL, 'Inactive', NULL, NULL, NULL, 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(18, 'Sequi aliquid', 'sequi-aliquid', NULL, 'Omnis sit quidem molestias possimus alias dolore. In doloremque vitae id omnis consequuntur dolorum. Aut nobis a debitis modi.', NULL, 'Inactive', NULL, NULL, NULL, 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(19, 'Recusandae', 'recusandae', NULL, 'Saepe sunt tempora cumque impedit possimus qui. Nisi nihil cupiditate et labore aut voluptatum. Beatae placeat odio expedita voluptate. Voluptatem nemo doloribus minima velit aliquam eveniet non.', NULL, 'Inactive', NULL, NULL, NULL, 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL),
(20, 'Dignissimos', 'dignissimos', NULL, 'Minima dolor error aut deleniti voluptatum at laboriosam tenetur. Atque et ut qui repellat. Vitae reiciendis harum non iusto ut ut repellat.', NULL, 'Inactive', NULL, NULL, NULL, 1, 1, NULL, '2026-04-03 18:24:50', '2026-04-03 18:24:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(191) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `first_name` varchar(191) DEFAULT NULL,
  `last_name` varchar(191) DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `mobile` varchar(191) DEFAULT NULL,
  `gender` varchar(191) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `social_profiles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_profiles`)),
  `avatar` varchar(191) DEFAULT NULL,
  `last_ip` varchar(191) DEFAULT NULL,
  `login_count` int(11) NOT NULL DEFAULT 0,
  `last_login` timestamp NULL DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `mobile`, `gender`, `date_of_birth`, `address`, `bio`, `social_profiles`, `avatar`, `last_ip`, `login_count`, `last_login`, `status`, `created_by`, `updated_by`, `deleted_by`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '100001', 'Super Admin', 'Super', 'Admin', 'super@admin.com', '2026-04-03 18:24:48', '$2y$12$1D.CtTidVavYoF3FdEL5R.ocWkgydN/0n8vsGGxAalDetRhiBuXp6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, NULL, NULL, NULL, NULL, '2026-04-03 18:24:48', '2026-04-03 18:24:48', NULL),
(2, '100002', 'Admin Istrator', 'Admin', 'Istrator', 'admin@admin.com', '2026-04-03 18:24:48', '$2y$12$nxehNpQt0yBbzsAEZ69OleNT47PNcqf0rr1r5fMbBMtKydJC8D.WS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, NULL, NULL, NULL, NULL, '2026-04-03 18:24:48', '2026-04-03 18:24:48', NULL),
(3, '100003', 'Manager User', 'Manager', 'User', 'manager@manager.com', '2026-04-03 18:24:48', '$2y$12$p.9gjj3eJKcYdJihabZsu.Y2gUo7wggxLxMgLxgOEAiyHSF6HpiYa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, NULL, NULL, NULL, NULL, '2026-04-03 18:24:48', '2026-04-03 18:24:48', NULL),
(4, '100004', 'Executive User', 'Executive', 'User', 'executive@executive.com', '2026-04-03 18:24:48', '$2y$12$KMnTrXHfDk16lwZSKkD2/.KK7YvvvjGzXJKNHCNszud.NT1I4pAxC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, NULL, NULL, NULL, NULL, '2026-04-03 18:24:48', '2026-04-03 18:24:48', NULL),
(5, '100005', 'General User', 'General', 'User', 'user@user.com', '2026-04-03 18:24:48', '$2y$12$3916IKocDtK3.VUijkCnAOhTjYLecsZb.29T4L6qqRbnAP5XHBNLO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, NULL, NULL, NULL, NULL, '2026-04-03 18:24:48', '2026-04-03 18:24:48', NULL),
(6, '100006', 'Vikash Kumar', 'Vikash', 'Kumar', 'vikash.work.dev@gmail.com', NULL, '$2y$12$.f0CB1c5UHnY27aYD7LijOT7PTi30QnE0PwyQB8VYa2k..OwmGt1O', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, 1, 1, NULL, NULL, '2026-04-03 23:50:19', '2026-04-03 23:51:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_providers`
--

CREATE TABLE `user_providers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `provider` varchar(191) NOT NULL,
  `provider_id` varchar(191) NOT NULL,
  `avatar` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `media_order_column_index` (`order_column`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_slug_unique` (`slug`),
  ADD KEY `menus_location_is_active_index` (`location`,`is_active`),
  ADD KEY `menus_locale_index` (`locale`),
  ADD KEY `menus_is_public_is_visible_index` (`is_public`,`is_visible`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_menu_id_foreign` (`menu_id`),
  ADD KEY `menu_items_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `rrdrs`
--
ALTER TABLE `rrdrs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taggables`
--
ALTER TABLE `taggables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_username_index` (`username`);

--
-- Indexes for table `user_providers`
--
ALTER TABLE `user_providers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_providers_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rrdrs`
--
ALTER TABLE `rrdrs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taggables`
--
ALTER TABLE `taggables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_providers`
--
ALTER TABLE `user_providers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_items_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_providers`
--
ALTER TABLE `user_providers`
  ADD CONSTRAINT `user_providers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
