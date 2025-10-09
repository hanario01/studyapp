--  phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2025-10-09 10:00:56
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;

--
-- データベース: `studyapp`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `questions`
--

CREATE TABLE `questions` (
    `id` int(11) NOT NULL,
    `grade` int(11) NOT NULL,
    `subject` varchar(20) NOT NULL,
    `question_text` text NOT NULL,
    `question_furigana` text DEFAULT NULL,
    `option1` varchar(255) NOT NULL,
    `option2` varchar(255) NOT NULL,
    `option3` varchar(255) NOT NULL,
    `option4` varchar(255) NOT NULL,
    `correct_option` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `questions`
--

INSERT INTO
    `questions` (
        `id`,
        `grade`,
        `subject`,
        `question_text`,
        `question_furigana`,
        `option1`,
        `option2`,
        `option3`,
        `option4`,
        `correct_option`
    )
VALUES (
        1,
        1,
        'kanji',
        '山はなんとよむ？',
        '',
        'かわ',
        'き',
        'やま',
        'た',
        3
    ),
    (
        2,
        1,
        'kanji',
        '川はなんとよむ？',
        '',
        'やま',
        'かわ',
        'みず',
        'いけ',
        2
    ),
    (
        3,
        1,
        'kanji',
        '木はなんとよむ？',
        '',
        'き',
        'こ',
        'け',
        'く',
        1
    ),
    (
        4,
        1,
        'kanji',
        '田はなんとよむ？',
        '',
        'はた',
        'た',
        'だ',
        'たけ',
        2
    ),
    (
        5,
        1,
        'kanji',
        '水はなんとよむ？',
        '',
        'みず',
        'かわ',
        'さけ',
        'うみ',
        1
    ),
    (
        6,
        1,
        'kanji',
        '空はなんとよむ？',
        '',
        'そら',
        'あめ',
        'くも',
        'ほし',
        1
    ),
    (
        7,
        1,
        'kanji',
        '火はなんとよむ？',
        '',
        'つき',
        'ひ',
        'ほし',
        'かぜ',
        2
    ),
    (
        8,
        1,
        'kanji',
        '月はなんとよむ？',
        '',
        'ひ',
        'つき',
        'ほし',
        'あさ',
        2
    ),
    (
        9,
        1,
        'kanji',
        '星はなんとよむ？',
        '',
        'そら',
        'つき',
        'ほし',
        'ひ',
        3
    ),
    (
        10,
        1,
        'kanji',
        '雲はなんとよむ？',
        '',
        'あめ',
        'くも',
        'そら',
        'ひ',
        2
    ),
    (
        11,
        1,
        'math',
        '1 + 2 はいくつ？',
        '',
        '1',
        '2',
        '3',
        '4',
        3
    ),
    (
        12,
        1,
        'math',
        '3 - 1 はいくつ？',
        '',
        '1',
        '2',
        '3',
        '4',
        2
    ),
    (
        13,
        1,
        'math',
        '2 + 2 はいくつ？',
        '',
        '3',
        '4',
        '5',
        '6',
        2
    ),
    (
        14,
        1,
        'math',
        '5 - 3 はいくつ？',
        '',
        '2',
        '3',
        '1',
        '4',
        1
    ),
    (
        15,
        1,
        'math',
        '1 + 4 はいくつ？',
        '',
        '4',
        '5',
        '6',
        '3',
        2
    ),
    (
        16,
        1,
        'math',
        '3 + 3 はいくつ？',
        '',
        '5',
        '6',
        '7',
        '8',
        2
    ),
    (
        17,
        1,
        'math',
        '6 - 2 はいくつ？',
        '',
        '3',
        '4',
        '5',
        '6',
        2
    ),
    (
        18,
        1,
        'math',
        '2 + 5 はいくつ？',
        '',
        '6',
        '7',
        '8',
        '5',
        2
    ),
    (
        19,
        1,
        'math',
        '4 - 1 はいくつ？',
        '',
        '2',
        '3',
        '1',
        '4',
        2
    ),
    (
        20,
        1,
        'math',
        '3 + 1 はいくつ？',
        '',
        '3',
        '4',
        '5',
        '2',
        2
    ),
    (
        21,
        1,
        'science',
        '太陽はどんな星？',
        '<ruby>太陽<rt>たいよう</rt></ruby> は どんな <ruby>星<rt>ほし</rt></ruby>？',
        'とても小さい',
        'あかるくてあつい',
        'つめたい',
        'みえない',
        2
    ),
    (
        22,
        1,
        'science',
        '雨がふったら何がぬれる？',
        '<ruby>あめ<rt>あめ</rt></ruby> がふったら 何がぬれる？',
        'くつ',
        'かさ',
        '傘',
        'みず',
        1
    ),
    (
        23,
        1,
        'science',
        '葉っぱは何色？',
        '<ruby>はっぱ<rt>はっぱ</rt></ruby> は 何色？',
        'みどり',
        'あか',
        'きいろ',
        'しろ',
        1
    ),
    (
        24,
        1,
        'science',
        '水はどこにある？',
        '<ruby>みず<rt>みず</rt></ruby> は どこにある？',
        'うみ',
        'そら',
        'たいよう',
        'つち',
        1
    ),
    (
        25,
        1,
        'science',
        '雲はどこにある？',
        '<ruby>くも<rt>くも</rt></ruby> は どこにある？',
        'そら',
        'みずうみ',
        'たいよう',
        'つち',
        1
    ),
    (
        26,
        1,
        'science',
        '鳥はどこでくらす？',
        '<ruby>とり<rt>とり</rt></ruby> は どこでくらす？',
        'みずうみ',
        'そら',
        '木の上',
        '土の中',
        3
    ),
    (
        27,
        1,
        'science',
        '雨はどんなときふる？',
        '<ruby>あめ<rt>あめ</rt></ruby> は どんなときふる？',
        'くもができたとき',
        'たいようがでたとき',
        'ふゆだけ',
        'はるだけ',
        1
    ),
    (
        28,
        1,
        'science',
        '夜になると見えるものは？',
        '<ruby>よる<rt>よる</rt></ruby> になると みえるものは？',
        'たいよう',
        'ほし',
        'くも',
        'みず',
        2
    ),
    (
        29,
        1,
        'science',
        '魚はどこにいる？',
        '<ruby>さかな<rt>さかな</rt></ruby> は どこにいる？',
        'そら',
        'つち',
        'うみ',
        'たいよう',
        3
    ),
    (
        30,
        1,
        'science',
        '風はどこからふく？',
        '<ruby>かぜ<rt>かぜ</rt></ruby> は どこからふく？',
        '地面',
        '木',
        '空',
        '空気の流れ',
        4
    ),
    (
        31,
        1,
        'social',
        '学校に行くのはなぜ？',
        '<ruby>がっこう<rt>がっこう</rt></ruby> に いくのは なぜ？',
        '勉強するため',
        'あそぶため',
        'ねるため',
        'たべるため',
        1
    ),
    (
        32,
        1,
        'social',
        'ごみはどこにすてる？',
        '<ruby>ごみ<rt>ごみ</rt></ruby> は どこに すてる？',
        '地面',
        'ごみ箱',
        '川',
        '森',
        2
    ),
    (
        33,
        1,
        'social',
        '信号の色は？',
        '<ruby>しんごう<rt>しんごう</rt></ruby> のいろは？',
        'あか、みどり、あお',
        'あか、みどり',
        'あか',
        'あお',
        1
    ),
    (
        34,
        1,
        'social',
        '道路は何のため？',
        '<ruby>どうろ<rt>どうろ</rt></ruby> は 何のため？',
        '歩くため',
        '走るため',
        '車が通るため',
        '家のため',
        3
    ),
    (
        35,
        1,
        'social',
        '日本の首都は？',
        '<ruby>にほん<rt>にほん</rt></ruby> の <ruby>首都<rt>しゅと</rt></ruby> は？',
        '大阪',
        '京都',
        '東京',
        '名古屋',
        3
    ),
    (
        36,
        1,
        'social',
        'みんなで遊ぶ場所は？',
        '<ruby>みんな<rt>みんな</rt></ruby> で あそぶ ばしょは？',
        '学校',
        '公園',
        '家',
        '川',
        2
    ),
    (
        37,
        1,
        'social',
        '手をあらうのはなぜ？',
        '<ruby>て<rt>て</rt></ruby> を あらう のは なぜ？',
        'けがを防ぐため',
        '手がきれいになるため',
        '遊ぶため',
        '勉強するため',
        1
    ),
    (
        38,
        1,
        'social',
        '信号は何のため？',
        '<ruby>しんごう<rt>しんごう</rt></ruby> は 何のため？',
        '安全にわたるため',
        '早くわたるため',
        '遊ぶため',
        '勉強するため',
        1
    ),
    (
        39,
        1,
        'social',
        '道を渡るときどうする？',
        '<ruby>みち<rt>みち</rt></ruby> を わたる とき どうする？',
        '右を見て渡る',
        '左を見て渡る',
        '左右を見て渡る',
        '止まる',
        3
    ),
    (
        40,
        1,
        'social',
        'ごはんはなぜ食べる？',
        '<ruby>ごはん<rt>ごはん</rt></ruby> は なぜ たべる？',
        'おなかを満たすため',
        '遊ぶため',
        '勉強するため',
        '寝るため',
        1
    );

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `questions`
--
ALTER TABLE `questions` ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `questions`
--
ALTER TABLE `questions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 41;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;