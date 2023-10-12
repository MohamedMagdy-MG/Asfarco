-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 18, 2023 at 07:09 AM
-- Server version: 5.7.33
-- PHP Version: 8.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asfarco`
--

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `nationality_en` varchar(255) NOT NULL,
  `nationality_ar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `code`, `name_en`, `name_ar`, `nationality_en`, `nationality_ar`) VALUES
(1, 'AF', 'Afghanistan', 'أفغانستان', 'Afghan', 'أفغانستاني'),
(2, 'AL', 'Albania', 'ألبانيا', 'Albanian', 'ألباني'),
(3, 'AX', 'Aland Islands', 'جزر آلاند', 'Aland Islander', 'آلاندي'),
(4, 'DZ', 'Algeria', 'الجزائر', 'Algerian', 'جزائري'),
(5, 'AS', 'American Samoa', 'ساموا-الأمريكي', 'American Samoan', 'أمريكي سامواني'),
(6, 'AD', 'Andorra', 'أندورا', 'Andorran', 'أندوري'),
(7, 'AO', 'Angola', 'أنغولا', 'Angolan', 'أنقولي'),
(8, 'AI', 'Anguilla', 'أنغويلا', 'Anguillan', 'أنغويلي'),
(9, 'AQ', 'Antarctica', 'أنتاركتيكا', 'Antarctican', 'أنتاركتيكي'),
(10, 'AG', 'Antigua and Barbuda', 'أنتيغوا وبربودا', 'Antiguan', 'بربودي'),
(11, 'AR', 'Argentina', 'الأرجنتين', 'Argentinian', 'أرجنتيني'),
(12, 'AM', 'Armenia', 'أرمينيا', 'Armenian', 'أرميني'),
(13, 'AW', 'Aruba', 'أروبه', 'Aruban', 'أوروبهيني'),
(14, 'AU', 'Australia', 'أستراليا', 'Australian', 'أسترالي'),
(15, 'AT', 'Austria', 'النمسا', 'Austrian', 'نمساوي'),
(16, 'AZ', 'Azerbaijan', 'أذربيجان', 'Azerbaijani', 'أذربيجاني'),
(17, 'BS', 'Bahamas', 'الباهاماس', 'Bahamian', 'باهاميسي'),
(18, 'BH', 'Bahrain', 'البحرين', 'Bahraini', 'بحريني'),
(19, 'BD', 'Bangladesh', 'بنغلاديش', 'Bangladeshi', 'بنغلاديشي'),
(20, 'BB', 'Barbados', 'بربادوس', 'Barbadian', 'بربادوسي'),
(21, 'BY', 'Belarus', 'روسيا البيضاء', 'Belarusian', 'روسي'),
(22, 'BE', 'Belgium', 'بلجيكا', 'Belgian', 'بلجيكي'),
(23, 'BZ', 'Belize', 'بيليز', 'Belizean', 'بيليزي'),
(24, 'BJ', 'Benin', 'بنين', 'Beninese', 'بنيني'),
(25, 'BL', 'Saint Barthelemy', 'سان بارتيلمي', 'Saint Barthelmian', 'سان بارتيلمي'),
(26, 'BM', 'Bermuda', 'جزر برمودا', 'Bermudan', 'برمودي'),
(27, 'BT', 'Bhutan', 'بوتان', 'Bhutanese', 'بوتاني'),
(28, 'BO', 'Bolivia', 'بوليفيا', 'Bolivian', 'بوليفي'),
(29, 'BA', 'Bosnia and Herzegovina', 'البوسنة و الهرسك', 'Bosnian / Herzegovinian', 'بوسني/هرسكي'),
(30, 'BW', 'Botswana', 'بوتسوانا', 'Botswanan', 'بوتسواني'),
(31, 'BV', 'Bouvet Island', 'جزيرة بوفيه', 'Bouvetian', 'بوفيهي'),
(32, 'BR', 'Brazil', 'البرازيل', 'Brazilian', 'برازيلي'),
(33, 'IO', 'British Indian Ocean Territory', 'إقليم المحيط الهندي البريطاني', 'British Indian Ocean Territory', 'إقليم المحيط الهندي البريطاني'),
(34, 'BN', 'Brunei Darussalam', 'بروني', 'Bruneian', 'بروني'),
(35, 'BG', 'Bulgaria', 'بلغاريا', 'Bulgarian', 'بلغاري'),
(36, 'BF', 'Burkina Faso', 'بوركينا فاسو', 'Burkinabe', 'بوركيني'),
(37, 'BI', 'Burundi', 'بوروندي', 'Burundian', 'بورونيدي'),
(38, 'KH', 'Cambodia', 'كمبوديا', 'Cambodian', 'كمبودي'),
(39, 'CM', 'Cameroon', 'كاميرون', 'Cameroonian', 'كاميروني'),
(40, 'CA', 'Canada', 'كندا', 'Canadian', 'كندي'),
(41, 'CV', 'Cape Verde', 'الرأس الأخضر', 'Cape Verdean', 'الرأس الأخضر'),
(42, 'KY', 'Cayman Islands', 'جزر كايمان', 'Caymanian', 'كايماني'),
(43, 'CF', 'Central African Republic', 'جمهورية أفريقيا الوسطى', 'Central African', 'أفريقي'),
(44, 'TD', 'Chad', 'تشاد', 'Chadian', 'تشادي'),
(45, 'CL', 'Chile', 'شيلي', 'Chilean', 'شيلي'),
(46, 'CN', 'China', 'الصين', 'Chinese', 'صيني'),
(47, 'CX', 'Christmas Island', 'جزيرة عيد الميلاد', 'Christmas Islander', 'جزيرة عيد الميلاد'),
(48, 'CC', 'Cocos (Keeling) Islands', 'جزر كوكوس', 'Cocos Islander', 'جزر كوكوس'),
(49, 'CO', 'Colombia', 'كولومبيا', 'Colombian', 'كولومبي'),
(50, 'KM', 'Comoros', 'جزر القمر', 'Comorian', 'جزر القمر'),
(51, 'CG', 'Congo', 'الكونغو', 'Congolese', 'كونغي'),
(52, 'CK', 'Cook Islands', 'جزر كوك', 'Cook Islander', 'جزر كوك'),
(53, 'CR', 'Costa Rica', 'كوستاريكا', 'Costa Rican', 'كوستاريكي'),
(54, 'HR', 'Croatia', 'كرواتيا', 'Croatian', 'كوراتي'),
(55, 'CU', 'Cuba', 'كوبا', 'Cuban', 'كوبي'),
(56, 'CY', 'Cyprus', 'قبرص', 'Cypriot', 'قبرصي'),
(57, 'CW', 'Curaçao', 'كوراساو', 'Curacian', 'كوراساوي'),
(58, 'CZ', 'Czech Republic', 'الجمهورية التشيكية', 'Czech', 'تشيكي'),
(59, 'DK', 'Denmark', 'الدانمارك', 'Danish', 'دنماركي'),
(60, 'DJ', 'Djibouti', 'جيبوتي', 'Djiboutian', 'جيبوتي'),
(61, 'DM', 'Dominica', 'دومينيكا', 'Dominican', 'دومينيكي'),
(62, 'DO', 'Dominican Republic', 'الجمهورية الدومينيكية', 'Dominican', 'دومينيكي'),
(63, 'EC', 'Ecuador', 'إكوادور', 'Ecuadorian', 'إكوادوري'),
(64, 'EG', 'Egypt', 'مصر', 'Egyptian', 'مصري'),
(65, 'SV', 'El Salvador', 'إلسلفادور', 'Salvadoran', 'سلفادوري'),
(66, 'GQ', 'Equatorial Guinea', 'غينيا الاستوائي', 'Equatorial Guinean', 'غيني'),
(67, 'ER', 'Eritrea', 'إريتريا', 'Eritrean', 'إريتيري'),
(68, 'EE', 'Estonia', 'استونيا', 'Estonian', 'استوني'),
(69, 'ET', 'Ethiopia', 'أثيوبيا', 'Ethiopian', 'أثيوبي'),
(70, 'FK', 'Falkland Islands (Malvinas)', 'جزر فوكلاند', 'Falkland Islander', 'فوكلاندي'),
(71, 'FO', 'Faroe Islands', 'جزر فارو', 'Faroese', 'جزر فارو'),
(72, 'FJ', 'Fiji', 'فيجي', 'Fijian', 'فيجي'),
(73, 'FI', 'Finland', 'فنلندا', 'Finnish', 'فنلندي'),
(74, 'FR', 'France', 'فرنسا', 'French', 'فرنسي'),
(75, 'GF', 'French Guiana', 'غويانا الفرنسية', 'French Guianese', 'غويانا الفرنسية'),
(76, 'PF', 'French Polynesia', 'بولينيزيا الفرنسية', 'French Polynesian', 'بولينيزيي'),
(77, 'TF', 'French Southern and Antarctic Lands', 'أراض فرنسية جنوبية وأنتارتيكية', 'French', 'أراض فرنسية جنوبية وأنتارتيكية'),
(78, 'GA', 'Gabon', 'الغابون', 'Gabonese', 'غابوني'),
(79, 'GM', 'Gambia', 'غامبيا', 'Gambian', 'غامبي'),
(80, 'GE', 'Georgia', 'جيورجيا', 'Georgian', 'جيورجي'),
(81, 'DE', 'Germany', 'ألمانيا', 'German', 'ألماني'),
(82, 'GH', 'Ghana', 'غانا', 'Ghanaian', 'غاني'),
(83, 'GI', 'Gibraltar', 'جبل طارق', 'Gibraltar', 'جبل طارق'),
(84, 'GG', 'Guernsey', 'غيرنزي', 'Guernsian', 'غيرنزي'),
(85, 'GR', 'Greece', 'اليونان', 'Greek', 'يوناني'),
(86, 'GL', 'Greenland', 'جرينلاند', 'Greenlandic', 'جرينلاندي'),
(87, 'GD', 'Grenada', 'غرينادا', 'Grenadian', 'غرينادي'),
(88, 'GP', 'Guadeloupe', 'جزر جوادلوب', 'Guadeloupe', 'جزر جوادلوب'),
(89, 'GU', 'Guam', 'جوام', 'Guamanian', 'جوامي'),
(90, 'GT', 'Guatemala', 'غواتيمال', 'Guatemalan', 'غواتيمالي'),
(91, 'GN', 'Guinea', 'غينيا', 'Guinean', 'غيني'),
(92, 'GW', 'Guinea-Bissau', 'غينيا-بيساو', 'Guinea-Bissauan', 'غيني'),
(93, 'GY', 'Guyana', 'غيانا', 'Guyanese', 'غياني'),
(94, 'HT', 'Haiti', 'هايتي', 'Haitian', 'هايتي'),
(95, 'HM', 'Heard and Mc Donald Islands', 'جزيرة هيرد وجزر ماكدونالد', 'Heard and Mc Donald Islanders', 'جزيرة هيرد وجزر ماكدونالد'),
(96, 'HN', 'Honduras', 'هندوراس', 'Honduran', 'هندوراسي'),
(97, 'HK', 'Hong Kong', 'هونغ كونغ', 'Hongkongese', 'هونغ كونغي'),
(98, 'HU', 'Hungary', 'المجر', 'Hungarian', 'مجري'),
(99, 'IS', 'Iceland', 'آيسلندا', 'Icelandic', 'آيسلندي'),
(100, 'IN', 'India', 'الهند', 'Indian', 'هندي'),
(101, 'IM', 'Isle of Man', 'جزيرة مان', 'Manx', 'ماني'),
(102, 'ID', 'Indonesia', 'أندونيسيا', 'Indonesian', 'أندونيسيي'),
(103, 'IR', 'Iran', 'إيران', 'Iranian', 'إيراني'),
(104, 'IQ', 'Iraq', 'العراق', 'Iraqi', 'عراقي'),
(105, 'IE', 'Ireland', 'إيرلندا', 'Irish', 'إيرلندي'),
(106, 'IL', 'Israel', 'إسرائيل', 'Israeli', 'إسرائيلي'),
(107, 'IT', 'Italy', 'إيطاليا', 'Italian', 'إيطالي'),
(108, 'CI', 'Ivory Coast', 'ساحل العاج', 'Ivory Coastian', 'ساحل العاج'),
(109, 'JE', 'Jersey', 'جيرزي', 'Jersian', 'جيرزي'),
(110, 'JM', 'Jamaica', 'جمايكا', 'Jamaican', 'جمايكي'),
(111, 'JP', 'Japan', 'اليابان', 'Japanese', 'ياباني'),
(112, 'JO', 'Jordan', 'الأردن', 'Jordanian', 'أردني'),
(113, 'KZ', 'Kazakhstan', 'كازاخستان', 'Kazakh', 'كازاخستاني'),
(114, 'KE', 'Kenya', 'كينيا', 'Kenyan', 'كيني'),
(115, 'KI', 'Kiribati', 'كيريباتي', 'I-Kiribati', 'كيريباتي'),
(116, 'KP', 'Korea(North Korea)', 'كوريا الشمالية', 'North Korean', 'كوري'),
(117, 'KR', 'Korea(South Korea)', 'كوريا الجنوبية', 'South Korean', 'كوري'),
(118, 'XK', 'Kosovo', 'كوسوفو', 'Kosovar', 'كوسيفي'),
(119, 'KW', 'Kuwait', 'الكويت', 'Kuwaiti', 'كويتي'),
(120, 'KG', 'Kyrgyzstan', 'قيرغيزستان', 'Kyrgyzstani', 'قيرغيزستاني'),
(121, 'LA', 'Lao PDR', 'لاوس', 'Laotian', 'لاوسي'),
(122, 'LV', 'Latvia', 'لاتفيا', 'Latvian', 'لاتيفي'),
(123, 'LB', 'Lebanon', 'لبنان', 'Lebanese', 'لبناني'),
(124, 'LS', 'Lesotho', 'ليسوتو', 'Basotho', 'ليوسيتي'),
(125, 'LR', 'Liberia', 'ليبيريا', 'Liberian', 'ليبيري'),
(126, 'LY', 'Libya', 'ليبيا', 'Libyan', 'ليبي'),
(127, 'LI', 'Liechtenstein', 'ليختنشتين', 'Liechtenstein', 'ليختنشتيني'),
(128, 'LT', 'Lithuania', 'لتوانيا', 'Lithuanian', 'لتوانيي'),
(129, 'LU', 'Luxembourg', 'لوكسمبورغ', 'Luxembourger', 'لوكسمبورغي'),
(130, 'LK', 'Sri Lanka', 'سريلانكا', 'Sri Lankian', 'سريلانكي'),
(131, 'MO', 'Macau', 'ماكاو', 'Macanese', 'ماكاوي'),
(132, 'MK', 'Macedonia', 'مقدونيا', 'Macedonian', 'مقدوني'),
(133, 'MG', 'Madagascar', 'مدغشقر', 'Malagasy', 'مدغشقري'),
(134, 'MW', 'Malawi', 'مالاوي', 'Malawian', 'مالاوي'),
(135, 'MY', 'Malaysia', 'ماليزيا', 'Malaysian', 'ماليزي'),
(136, 'MV', 'Maldives', 'المالديف', 'Maldivian', 'مالديفي'),
(137, 'ML', 'Mali', 'مالي', 'Malian', 'مالي'),
(138, 'MT', 'Malta', 'مالطا', 'Maltese', 'مالطي'),
(139, 'MH', 'Marshall Islands', 'جزر مارشال', 'Marshallese', 'مارشالي'),
(140, 'MQ', 'Martinique', 'مارتينيك', 'Martiniquais', 'مارتينيكي'),
(141, 'MR', 'Mauritania', 'موريتانيا', 'Mauritanian', 'موريتانيي'),
(142, 'MU', 'Mauritius', 'موريشيوس', 'Mauritian', 'موريشيوسي'),
(143, 'YT', 'Mayotte', 'مايوت', 'Mahoran', 'مايوتي'),
(144, 'MX', 'Mexico', 'المكسيك', 'Mexican', 'مكسيكي'),
(145, 'FM', 'Micronesia', 'مايكرونيزيا', 'Micronesian', 'مايكرونيزيي'),
(146, 'MD', 'Moldova', 'مولدافيا', 'Moldovan', 'مولديفي'),
(147, 'MC', 'Monaco', 'موناكو', 'Monacan', 'مونيكي'),
(148, 'MN', 'Mongolia', 'منغوليا', 'Mongolian', 'منغولي'),
(149, 'ME', 'Montenegro', 'الجبل الأسود', 'Montenegrin', 'الجبل الأسود'),
(150, 'MS', 'Montserrat', 'مونتسيرات', 'Montserratian', 'مونتسيراتي'),
(151, 'MA', 'Morocco', 'المغرب', 'Moroccan', 'مغربي'),
(152, 'MZ', 'Mozambique', 'موزمبيق', 'Mozambican', 'موزمبيقي'),
(153, 'MM', 'Myanmar', 'ميانمار', 'Myanmarian', 'ميانماري'),
(154, 'NA', 'Namibia', 'ناميبيا', 'Namibian', 'ناميبي'),
(155, 'NR', 'Nauru', 'نورو', 'Nauruan', 'نوري'),
(156, 'NP', 'Nepal', 'نيبال', 'Nepalese', 'نيبالي'),
(157, 'NL', 'Netherlands', 'هولندا', 'Dutch', 'هولندي'),
(158, 'AN', 'Netherlands Antilles', 'جزر الأنتيل الهولندي', 'Dutch Antilier', 'هولندي'),
(159, 'NC', 'New Caledonia', 'كاليدونيا الجديدة', 'New Caledonian', 'كاليدوني'),
(160, 'NZ', 'New Zealand', 'نيوزيلندا', 'New Zealander', 'نيوزيلندي'),
(161, 'NI', 'Nicaragua', 'نيكاراجوا', 'Nicaraguan', 'نيكاراجوي'),
(162, 'NE', 'Niger', 'النيجر', 'Nigerien', 'نيجيري'),
(163, 'NG', 'Nigeria', 'نيجيريا', 'Nigerian', 'نيجيري'),
(164, 'NU', 'Niue', 'ني', 'Niuean', 'ني'),
(165, 'NF', 'Norfolk Island', 'جزيرة نورفولك', 'Norfolk Islander', 'نورفوليكي'),
(166, 'MP', 'Northern Mariana Islands', 'جزر ماريانا الشمالية', 'Northern Marianan', 'ماريني'),
(167, 'NO', 'Norway', 'النرويج', 'Norwegian', 'نرويجي'),
(168, 'OM', 'Oman', 'عمان', 'Omani', 'عماني'),
(169, 'PK', 'Pakistan', 'باكستان', 'Pakistani', 'باكستاني'),
(170, 'PW', 'Palau', 'بالاو', 'Palauan', 'بالاوي'),
(171, 'PS', 'Palestine', 'فلسطين', 'Palestinian', 'فلسطيني'),
(172, 'PA', 'Panama', 'بنما', 'Panamanian', 'بنمي'),
(173, 'PG', 'Papua New Guinea', 'بابوا غينيا الجديدة', 'Papua New Guinean', 'بابوي'),
(174, 'PY', 'Paraguay', 'باراغواي', 'Paraguayan', 'بارغاوي'),
(175, 'PE', 'Peru', 'بيرو', 'Peruvian', 'بيري'),
(176, 'PH', 'Philippines', 'الفليبين', 'Filipino', 'فلبيني'),
(177, 'PN', 'Pitcairn', 'بيتكيرن', 'Pitcairn Islander', 'بيتكيرني'),
(178, 'PL', 'Poland', 'بولندا', 'Polish', 'بولندي'),
(179, 'PT', 'Portugal', 'البرتغال', 'Portuguese', 'برتغالي'),
(180, 'PR', 'Puerto Rico', 'بورتو ريكو', 'Puerto Rican', 'بورتي'),
(181, 'QA', 'Qatar', 'قطر', 'Qatari', 'قطري'),
(182, 'RE', 'Reunion Island', 'ريونيون', 'Reunionese', 'ريونيوني'),
(183, 'RO', 'Romania', 'رومانيا', 'Romanian', 'روماني'),
(184, 'RU', 'Russian', 'روسيا', 'Russian', 'روسي'),
(185, 'RW', 'Rwanda', 'رواندا', 'Rwandan', 'رواندا'),
(186, 'KN', 'Saint Kitts and Nevis', 'سانت كيتس ونيفس,', 'Kittitian/Nevisian', 'سانت كيتس ونيفس'),
(187, 'MF', 'Saint Martin (French part)', 'ساينت مارتن فرنسي', 'St. Martian(French)', 'ساينت مارتني فرنسي'),
(188, 'SX', 'Sint Maarten (Dutch part)', 'ساينت مارتن هولندي', 'St. Martian(Dutch)', 'ساينت مارتني هولندي'),
(189, 'LC', 'Saint Pierre and Miquelon', 'سان بيير وميكلون', 'St. Pierre and Miquelon', 'سان بيير وميكلوني'),
(190, 'VC', 'Saint Vincent and the Grenadines', 'سانت فنسنت وجزر غرينادين', 'Saint Vincent and the Grenadines', 'سانت فنسنت وجزر غرينادين'),
(191, 'WS', 'Samoa', 'ساموا', 'Samoan', 'ساموي'),
(192, 'SM', 'San Marino', 'سان مارينو', 'Sammarinese', 'ماريني'),
(193, 'ST', 'Sao Tome and Principe', 'ساو تومي وبرينسيبي', 'Sao Tomean', 'ساو تومي وبرينسيبي'),
(194, 'SA', 'Saudi Arabia', 'المملكة العربية السعودية', 'Saudi Arabian', 'سعودي'),
(195, 'SN', 'Senegal', 'السنغال', 'Senegalese', 'سنغالي'),
(196, 'RS', 'Serbia', 'صربيا', 'Serbian', 'صربي'),
(197, 'SC', 'Seychelles', 'سيشيل', 'Seychellois', 'سيشيلي'),
(198, 'SL', 'Sierra Leone', 'سيراليون', 'Sierra Leonean', 'سيراليوني'),
(199, 'SG', 'Singapore', 'سنغافورة', 'Singaporean', 'سنغافوري'),
(200, 'SK', 'Slovakia', 'سلوفاكيا', 'Slovak', 'سولفاكي'),
(201, 'SI', 'Slovenia', 'سلوفينيا', 'Slovenian', 'سولفيني'),
(202, 'SB', 'Solomon Islands', 'جزر سليمان', 'Solomon Island', 'جزر سليمان'),
(203, 'SO', 'Somalia', 'الصومال', 'Somali', 'صومالي'),
(204, 'ZA', 'South Africa', 'جنوب أفريقيا', 'South African', 'أفريقي'),
(205, 'GS', 'South Georgia and the South Sandwich', 'المنطقة القطبية الجنوبية', 'South Georgia and the South Sandwich', 'لمنطقة القطبية الجنوبية'),
(206, 'SS', 'South Sudan', 'السودان الجنوبي', 'South Sudanese', 'سوادني جنوبي'),
(207, 'ES', 'Spain', 'إسبانيا', 'Spanish', 'إسباني'),
(208, 'SH', 'Saint Helena', 'سانت هيلانة', 'St. Helenian', 'هيلاني'),
(209, 'SD', 'Sudan', 'السودان', 'Sudanese', 'سوداني'),
(210, 'SR', 'Suriname', 'سورينام', 'Surinamese', 'سورينامي'),
(211, 'SJ', 'Svalbard and Jan Mayen', 'سفالبارد ويان ماين', 'Svalbardian/Jan Mayenian', 'سفالبارد ويان ماين'),
(212, 'SZ', 'Swaziland', 'سوازيلند', 'Swazi', 'سوازيلندي'),
(213, 'SE', 'Sweden', 'السويد', 'Swedish', 'سويدي'),
(214, 'CH', 'Switzerland', 'سويسرا', 'Swiss', 'سويسري'),
(215, 'SY', 'Syria', 'سوريا', 'Syrian', 'سوري'),
(216, 'TW', 'Taiwan', 'تايوان', 'Taiwanese', 'تايواني'),
(217, 'TJ', 'Tajikistan', 'طاجيكستان', 'Tajikistani', 'طاجيكستاني'),
(218, 'TZ', 'Tanzania', 'تنزانيا', 'Tanzanian', 'تنزانيي'),
(219, 'TH', 'Thailand', 'تايلندا', 'Thai', 'تايلندي'),
(220, 'TL', 'Timor-Leste', 'تيمور الشرقية', 'Timor-Lestian', 'تيموري'),
(221, 'TG', 'Togo', 'توغو', 'Togolese', 'توغي'),
(222, 'TK', 'Tokelau', 'توكيلاو', 'Tokelaian', 'توكيلاوي'),
(223, 'TO', 'Tonga', 'تونغا', 'Tongan', 'تونغي'),
(224, 'TT', 'Trinidad and Tobago', 'ترينيداد وتوباغو', 'Trinidadian/Tobagonian', 'ترينيداد وتوباغو'),
(225, 'TN', 'Tunisia', 'تونس', 'Tunisian', 'تونسي'),
(226, 'TR', 'Turkey', 'تركيا', 'Turkish', 'تركي'),
(227, 'TM', 'Turkmenistan', 'تركمانستان', 'Turkmen', 'تركمانستاني'),
(228, 'TC', 'Turks and Caicos Islands', 'جزر توركس وكايكوس', 'Turks and Caicos Islands', 'جزر توركس وكايكوس'),
(229, 'TV', 'Tuvalu', 'توفالو', 'Tuvaluan', 'توفالي'),
(230, 'UG', 'Uganda', 'أوغندا', 'Ugandan', 'أوغندي'),
(231, 'UA', 'Ukraine', 'أوكرانيا', 'Ukrainian', 'أوكراني'),
(232, 'AE', 'United Arab Emirates', 'الإمارات العربية المتحدة', 'Emirati', 'إماراتي'),
(233, 'GB', 'United Kingdom', 'المملكة المتحدة', 'British', 'بريطاني'),
(234, 'US', 'United States', 'الولايات المتحدة', 'American', 'أمريكي'),
(235, 'UM', 'US Minor Outlying Islands', 'قائمة الولايات والمناطق الأمريكية', 'US Minor Outlying Islander', 'أمريكي'),
(236, 'UY', 'Uruguay', 'أورغواي', 'Uruguayan', 'أورغواي'),
(237, 'UZ', 'Uzbekistan', 'أوزباكستان', 'Uzbek', 'أوزباكستاني'),
(238, 'VU', 'Vanuatu', 'فانواتو', 'Vanuatuan', 'فانواتي'),
(239, 'VE', 'Venezuela', 'فنزويلا', 'Venezuelan', 'فنزويلي'),
(240, 'VN', 'Vietnam', 'فيتنام', 'Vietnamese', 'فيتنامي'),
(241, 'VI', 'Virgin Islands (U.S.)', 'الجزر العذراء الأمريكي', 'American Virgin Islander', 'أمريكي'),
(242, 'VA', 'Vatican City', 'فنزويلا', 'Vatican', 'فاتيكاني'),
(243, 'WF', 'Wallis and Futuna Islands', 'والس وفوتونا', 'Wallisian/Futunan', 'فوتوني'),
(244, 'EH', 'Western Sahara', 'الصحراء الغربية', 'Sahrawian', 'صحراوي'),
(245, 'YE', 'Yemen', 'اليمن', 'Yemeni', 'يمني'),
(246, 'ZM', 'Zambia', 'زامبيا', 'Zambian', 'زامبياني'),
(247, 'ZW', 'Zimbabwe', 'زمبابوي', 'Zimbabwean', 'زمبابوي');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
