CREATE DATABASE IF NOT EXISTS socialnetwork;

USE socialnetwork;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;


/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;


/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;


/*!40101 SET NAMES utf8mb4 */
;

CREATE TABLE `LIKES` (
    `id` int(11) NOT NULL,
    `userID` int(11) NOT NULL,
    `postID` int(11) NOT NULL) ENGINE = InnoDB DEFAULT CHARSET = latin1;

CREATE TABLE `LOGINREQUESTS` (
    `id` int(11) NOT NULL,
    `USERDETAILS_id` int(11) DEFAULT NULL,
    `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
    `ip` varchar(128) DEFAULT NULL,
    `successful` tinyint (1) DEFAULT NULL) ENGINE = InnoDB DEFAULT CHARSET = latin1;

INSERT INTO `LOGINREQUESTS` (`id`, `USERDETAILS_id`, `datetime`, `ip`, `successful`)
    VALUES (1, 1, '2018-01-03 19:48:28', NULL, NULL),
    (2, 1, '2018-01-03 19:50:25', NULL, NULL),
    (3, 5, '2018-01-03 20:00:03', NULL, NULL),
    (4, 10, '2018-01-04 13:40:12', NULL, NULL),
    (5, 11, '2018-01-04 13:53:01', NULL, NULL),
    (6, 12, '2018-01-04 20:48:50', NULL, NULL),
    (7, 13, '2018-01-04 20:50:54', NULL, NULL),
    (8, 14, '2018-01-04 21:03:02', NULL, NULL),
    (9, 15, '2018-01-14 15:26:46', NULL, NULL),
    (10, 16, '2018-01-14 15:45:44', NULL, NULL);

CREATE TABLE `POSTS` (
    `id` int(11) NOT NULL,
    `photopath` varchar(512) NOT NULL,
    `userID` int(11) NOT NULL,
    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE = InnoDB DEFAULT CHARSET = latin1;

INSERT INTO `POSTS` (`id`, `photopath`, `userID`, `date`)
    VALUES (47, 'store/posts/2468896350bef59e5dad28250d22ec39fe7a403116bf05d6fb7145ea0af7567f.jpg', 1, '2024-01-17 23:11:05'),
    (48, 'store/posts/6f86f7dabe420a55d3584e94d2399063ce541062768e22dd3ad0d7c304777478.jpg', 1, '2024-01-17 23:11:09'),
    (49, 'store/posts/cf9475b7349540d3955aaab04e2b4971e55f5bd514c336b0b396b57ab37dd8d5.jpg', 1, '2024-01-17 23:11:11'),
    (54, 'store/posts/615fdff99ca31f11e42a581ac62122df27f37d3346fdb2c5997fa9dc4cdd1a51.jpg', 2, '2024-01-17 23:16:56');

CREATE TABLE `USERDETAILS` (
    `id` int(11) NOT NULL,
    `username` varchar(255) character
    SET utf8 COLLATE utf8_bin DEFAULT NULL,
    `email` varchar(255) character
    SET utf8 COLLATE utf8_bin DEFAULT NULL,
    `passwordhash` varchar(128) character
    SET utf8 COLLATE utf8_bin DEFAULT NULL,
    `current` tinyint (1) NOT NULL DEFAULT '1',
    `activated` tinyint (1) DEFAULT '1',
    `deleted` tinyint (1) DEFAULT '0',
    `signup_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `firstname` varchar(128) character
    SET utf8 COLLATE utf8_bin DEFAULT NULL,
    `middlename` varchar(128) character
    SET utf8 COLLATE utf8_bin DEFAULT NULL,
    `surname` varchar(128) character
    SET utf8 COLLATE utf8_bin DEFAULT NULL,
    `gender` enum ('female', 'male', 'none', '') character
    SET utf8 COLLATE utf8_bin DEFAULT 'none',
    `website` varchar(256) character
    SET utf8 COLLATE utf8_bin DEFAULT NULL,
    `country` varchar(10) character
    SET utf8 COLLATE utf8_bin DEFAULT NULL,
    `language` varchar(10) character
    SET utf8 COLLATE utf8_bin DEFAULT 'tr-TR',
    `profilephoto` varchar(128) character
    SET utf8 COLLATE utf8_bin DEFAULT NULL,
    `profilephoto_fullpath` varchar(256) character
    SET utf8 COLLATE utf8_bin DEFAULT NULL) ENGINE = InnoDB DEFAULT CHARSET = latin1;

INSERT INTO `USERDETAILS` (`id`, `username`, `email`, `passwordhash`, `current`, `activated`, `deleted`, `signup_date`, `firstname`, `middlename`, `surname`, `gender`, `website`, `country`, `language`, `profilephoto`, `profilephoto_fullpath`)
    VALUES (1, 'ralph', '1@localhost', '$2y$10$vI9DdYY2X2O9H3eBaHedfOoMQU6z8I.5zulY2xkHRaULmHMOM.1lq', 1, 1, 0, '2018-01-03 20:00:03', 'Ralph', NULL, 'Spencer', 'none', NULL, NULL, 'en-US', '', 'store/profilephotos/5X5fgBMF331kb8mjfoVjBnZ5lGIJanwE.jpg'),
    (2, 'nicholas', '2@localhost', '$2y$10$MNnjat/LgeuuskPrrMkbFOhM4dvm3Y6cK.BtWCCyDMFN9yNckJ.SW', 1, 1, 0, '2018-01-04 13:53:01', 'Nicholas', NULL, 'Hall', 'none', NULL, NULL, 'en-US', NULL, 'store/profilephotos/8HwMASHRA0skFBtuB0tYPvgxu0aUgHqg.jpg'),
    (3, 'david', '3@localhost', '$2y$10$r/B9kB/lEtJwt8WJfI06ROjkFACjYw5ZJXaQzOy372bTJd8VIIou6', 1, 1, 0, '2018-01-04 20:48:50', 'David', NULL, 'Kennedy', 'none', NULL, NULL, 'en-US', NULL, 'store/profilephotos/8yDiRNZjFkH4UiZIogkJmS6LwZZx2oVz.jpg'),
    (4, 'nina', '4@localhost', '$2y$10$TcwxSKXTEM4bJ/PAnJzOC.xuHot7vg59koepmYnmPa.0u8EsGMEQS', 1, 1, 0, '2018-01-04 20:50:54', 'Nina', NULL, 'Carlson', 'none', NULL, NULL, 'en-US', NULL, 'store/profilephotos/8yVRhhL6TotNSVVt7XeuqAbJxKhTXcBu.jpg'),
    (5, 'henrietta', '5@localhost', '$2y$10$qXxNGFuUjOrR0QUcLPmeguTjFvEdxu4XD1t.O8OIvIgZtaFf/3Fba', 1, 1, 0, '2018-01-04 21:03:02', 'Henrietta', NULL, 'Newman', 'none', NULL, NULL, 'en-US', NULL, 'store/profilephotos/9FdKb2jdUnVb3PGmKbHokjfekSkTRdrX.jpg'),
    (6, 'wayne', '6@localhost', '$2y$10$vI9DdYY2X2O9H3eBaHedfOoMQU6z8I.5zulY2xkHRaULmHMOM.1lq', 1, 1, 0, '2018-01-03 20:00:03', 'Wayne', NULL, 'Lamb', 'none', NULL, NULL, 'en-US', '', 'store/profilephotos/B7wY5ECovvnOrUiZePPWmCtAfR3PdIbr.jpg'),
    (7, 'mason', '7@localhost', '$2y$10$MNnjat/LgeuuskPrrMkbFOhM4dvm3Y6cK.BtWCCyDMFN9yNckJ.SW', 1, 1, 0, '2018-01-04 13:53:01', 'Mason', NULL, 'Guerrero', 'none', NULL, NULL, 'en-US', NULL, 'store/profilephotos/bA9oWQeE9nFjeftRuq9WdhWCMdPTOtI4.jpg'),
    (8, 'clyde', '8@localhost', '$2y$10$r/B9kB/lEtJwt8WJfI06ROjkFACjYw5ZJXaQzOy372bTJd8VIIou6', 1, 1, 0, '2018-01-04 20:48:50', 'Clyde', NULL, 'Evans', 'none', NULL, NULL, 'en-US', NULL, 'store/profilephotos/BnSFJpwB62sdo8yKGKsoXLKrx4IMT90v.jpg'),
    (9, 'arthur', '9@localhost', '$2y$10$TcwxSKXTEM4bJ/PAnJzOC.xuHot7vg59koepmYnmPa.0u8EsGMEQS', 1, 1, 0, '2018-01-04 20:50:54', 'Arthur', NULL, 'Casey', 'none', NULL, NULL, 'en-US', NULL, 'store/profilephotos/bO9kkNmH6xzNx4CCq3wvRuhlZvKmeDPL.jpg'),
    (10, 'esther', '10@localhost', '$2y$10$qXxNGFuUjOrR0QUcLPmeguTjFvEdxu4XD1t.O8OIvIgZtaFf/3Fba', 1, 1, 0, '2018-01-04 21:03:02', 'Esther', NULL, 'Hayes', 'none', NULL, NULL, 'en-US', NULL, 'store/profilephotos/CGkvMg1SiPBdA55PB4cT6Ew3XFC6xfVB.jpg'),
    (11, 'alice', '11@localhost', '$2y$10$vI9DdYY2X2O9H3eBaHedfOoMQU6z8I.5zulY2xkHRaULmHMOM.1lq', 1, 1, 0, '2018-01-03 20:00:03', 'Alice', NULL, 'Robertson', 'none', NULL, NULL, 'en-US', '', 'store/profilephotos/CIDuuqiNBajG0WRksn9XoZzTHoN2Bup6.jpg'),
    (12, 'ınez', '12@localhost', '$2y$10$MNnjat/LgeuuskPrrMkbFOhM4dvm3Y6cK.BtWCCyDMFN9yNckJ.SW', 1, 1, 0, '2018-01-04 13:53:01', 'Inez', NULL, 'Hayes', 'none', NULL, NULL, 'en-US', NULL, 'store/profilephotos/dpK0jYtDTBIhzR7fwTxKLaV3UoLKAcR4.jpg'),
    (13, 'ralph', '13@localhost', '$2y$10$r/B9kB/lEtJwt8WJfI06ROjkFACjYw5ZJXaQzOy372bTJd8VIIou6', 1, 1, 0, '2018-01-04 20:48:50', 'Ralph', NULL, 'Klein', 'none', NULL, NULL, 'en-US', NULL, 'store/profilephotos/DxACYhLTRjJQqJGjOa751MlHrUXys1LY.jpg'),
    (14, 'douglas', '14@localhost', '$2y$10$TcwxSKXTEM4bJ/PAnJzOC.xuHot7vg59koepmYnmPa.0u8EsGMEQS', 1, 1, 0, '2018-01-04 20:50:54', 'Douglas', NULL, 'Nelson', 'none', NULL, NULL, 'en-US', NULL, 'store/profilephotos/fjC7vn1iS2bTmfcaX7SQp89xNMGdU9sZ.jpg'),
    (15, 'linnie', '15@localhost', '$2y$10$qXxNGFuUjOrR0QUcLPmeguTjFvEdxu4XD1t.O8OIvIgZtaFf/3Fba', 1, 1, 0, '2018-01-04 21:03:02', 'Linnie', NULL, 'Romero', 'none', NULL, NULL, 'en-US', NULL, 'store/profilephotos/GFIaszKc9rMutPtFVAxNyLpflFPueo06.jpg'),
    (16, 'marian', '16@localhost', '$2y$10$vI9DdYY2X2O9H3eBaHedfOoMQU6z8I.5zulY2xkHRaULmHMOM.1lq', 1, 1, 0, '2018-01-03 20:00:03', 'Marian', NULL, 'Houston', 'none', NULL, NULL, 'en-US', '', 'store/profilephotos/IQrh9W6gKllyKMUjFX00lnMCtz6WrpZv.jpg'),
    (17, 'johanna', '17@localhost', '$2y$10$MNnjat/LgeuuskPrrMkbFOhM4dvm3Y6cK.BtWCCyDMFN9yNckJ.SW', 1, 1, 0, '2018-01-04 13:53:01', 'Johanna', NULL, 'Watson', 'none', NULL, NULL, 'en-US', NULL, 'store/profilephotos/JIdmV9RYEtkNvscCTodfqTQYX3qWM7Mh.jpg'),
    (18, 'ruby', '18@localhost', '$2y$10$r/B9kB/lEtJwt8WJfI06ROjkFACjYw5ZJXaQzOy372bTJd8VIIou6', 1, 1, 0, '2018-01-04 20:48:50', 'Ruby', NULL, 'Oliver', 'none', NULL, NULL, 'en-US', NULL, 'store/profilephotos/k7igg4aMv1kn3nuCH0LCnvurQYUJWgOj.jpg'),
    (19, 'lenora', '19@localhost', '$2y$10$TcwxSKXTEM4bJ/PAnJzOC.xuHot7vg59koepmYnmPa.0u8EsGMEQS', 1, 1, 0, '2018-01-04 20:50:54', 'Lenora', NULL, 'Pierce', 'none', NULL, NULL, 'en-US', NULL, 'store/profilephotos/kpt9SJffG0eLRsFw4G6UIJVvhLDOFrvi.jpg'),
    (20, 'eleanor', '20@localhost', '$2y$10$qXxNGFuUjOrR0QUcLPmeguTjFvEdxu4XD1t.O8OIvIgZtaFf/3Fba', 1, 1, 0, '2018-01-04 21:03:02', 'Eleanor', NULL, 'Garcia', 'none', NULL, NULL, 'en-US', NULL, 'store/profilephotos/n8jE5AzhnT4pwe7XCxjOxS9afwTdKPlu.jpg'),
    (21, 'eva', '21@localhost', '$2y$10$vI9DdYY2X2O9H3eBaHedfOoMQU6z8I.5zulY2xkHRaULmHMOM.1lq', 1, 1, 0, '2018-01-03 20:00:03', 'Eva', NULL, 'Alvarado', 'none', NULL, NULL, 'en-US', '', 'store/profilephotos/PrbIBzeeC6nSMn17YO3o8I57mC8fANKy.jpg'),
    (22, 'eva', '22@localhost', '$2y$10$MNnjat/LgeuuskPrrMkbFOhM4dvm3Y6cK.BtWCCyDMFN9yNckJ.SW', 1, 1, 0, '2018-01-04 13:53:01', 'Eva', NULL, 'Ross', 'none', NULL, NULL, 'en-US', NULL, 'store/profilephotos/T2SzvdeMYEGXNFUDu3f5vXwihhDRUPiM.jpg'),
    (23, 'vernon', '23@localhost', '$2y$10$r/B9kB/lEtJwt8WJfI06ROjkFACjYw5ZJXaQzOy372bTJd8VIIou6', 1, 1, 0, '2018-01-04 20:48:50', 'Vernon', NULL, 'Gill', 'none', NULL, NULL, 'en-US', NULL, 'store/profilephotos/ufAbdKZAUYz66Uhvsh9dooUhvxOtBkGS.jpg'),
    (24, 'ollie', '24@localhost', '$2y$10$TcwxSKXTEM4bJ/PAnJzOC.xuHot7vg59koepmYnmPa.0u8EsGMEQS', 1, 1, 0, '2018-01-04 20:50:54', 'Ollie', NULL, 'Cannon', 'none', NULL, NULL, 'en-US', NULL, 'store/profilephotos/V2y8mULI1Kfbxo8IGUe3idkabiTaTPCt.jpg'),
    (25, 'alberta', '25@localhost', '$2y$10$qXxNGFuUjOrR0QUcLPmeguTjFvEdxu4XD1t.O8OIvIgZtaFf/3Fba', 1, 1, 0, '2018-01-04 21:03:02', 'Alberta', NULL, 'Nunez', 'none', NULL, NULL, 'en-US', NULL, 'store/profilephotos/WYnzR1kMpI02DMqdsNuDnTVfmWSTolZm.jpg');

CREATE TABLE `USERRELATIONS` (
    `id` int(11) NOT NULL,
    `firstUserID` int(11) DEFAULT NULL,
    `secondUserID` int(11) DEFAULT NULL,
    `state` enum ('baslangic', 'istegecevapbekleniyor', 'istegecevapverilecek', 'kullanicitakipediyor', 'karsitaraftakipediyor', 'arkadaslik', 'kullaniciengelli', 'karsitarafengelli', 'karslikliengel') NOT NULL DEFAULT 'baslangic') ENGINE = InnoDB DEFAULT CHARSET = latin1;

INSERT INTO `USERRELATIONS` (`id`, `firstUserID`, `secondUserID`, `state`)
    VALUES (1, 11, 5, 'arkadaslik'),
    (2, 5, 11, 'arkadaslik'),
    (3, 12, 11, 'istegecevapbekleniyor'),
    (4, 11, 12, 'istegecevapverilecek'),
    (5, 12, 5, 'arkadaslik'),
    (6, 5, 12, 'arkadaslik'),
    (7, 13, 11, 'istegecevapbekleniyor'),
    (8, 11, 13, 'istegecevapverilecek'),
    (9, 13, 5, 'arkadaslik'),
    (10, 5, 13, 'arkadaslik'),
    (11, 13, 12, 'istegecevapbekleniyor'),
    (12, 12, 13, 'istegecevapverilecek'),
    (13, 14, 11, 'kullanicitakipediyor'),
    (14, 11, 14, 'karsitaraftakipediyor'),
    (15, 14, 5, 'arkadaslik'),
    (16, 5, 14, 'arkadaslik'),
    (17, 14, 12, 'istegecevapbekleniyor'),
    (18, 12, 14, 'istegecevapverilecek'),
    (19, 14, 13, 'istegecevapbekleniyor'),
    (20, 13, 14, 'istegecevapverilecek'),
    (21, 1, 2, 'arkadaslik'),
    (22, 2, 1, 'arkadaslik'),
    (23, 1, 3, 'arkadaslik'),
    (24, 3, 1, 'arkadaslik'),
    (25, 1, 4, 'arkadaslik'),
    (26, 4, 1, 'arkadaslik'),
    (27, 1, 5, 'arkadaslik'),
    (28, 5, 1, 'arkadaslik'),
    (29, 1, 6, 'arkadaslik'),
    (30, 6, 1, 'arkadaslik'),
    (31, 1, 7, 'arkadaslik'),
    (32, 7, 1, 'arkadaslik'),
    (33, 1, 8, 'arkadaslik'),
    (34, 8, 1, 'arkadaslik'),
    (35, 1, 9, 'arkadaslik'),
    (36, 9, 1, 'arkadaslik'),
    (37, 1, 10, 'arkadaslik'),
    (38, 10, 1, 'arkadaslik'),
    (39, 1, 11, 'arkadaslik'),
    (40, 11, 1, 'arkadaslik'),
    (41, 1, 12, 'arkadaslik'),
    (42, 12, 1, 'arkadaslik'),
    (43, 1, 13, 'arkadaslik'),
    (44, 13, 1, 'arkadaslik'),
    (45, 1, 14, 'arkadaslik'),
    (46, 14, 1, 'arkadaslik'),
    (47, 1, 15, 'arkadaslik'),
    (48, 15, 1, 'arkadaslik'),
    (49, 1, 16, 'arkadaslik'),
    (50, 16, 1, 'arkadaslik'),
    (51, 1, 17, 'arkadaslik'),
    (52, 17, 1, 'arkadaslik'),
    (53, 1, 19, 'arkadaslik'),
    (54, 19, 1, 'arkadaslik'),
    (55, 1, 18, 'arkadaslik'),
    (56, 18, 1, 'arkadaslik'),
    (57, 1, 20, 'arkadaslik'),
    (58, 20, 1, 'arkadaslik'),
    (59, 1, 21, 'arkadaslik'),
    (60, 21, 1, 'arkadaslik'),
    (61, 1, 22, 'arkadaslik'),
    (62, 22, 1, 'arkadaslik'),
    (63, 1, 23, 'arkadaslik'),
    (64, 23, 1, 'arkadaslik'),
    (65, 1, 24, 'arkadaslik'),
    (66, 24, 1, 'arkadaslik'),
    (67, 1, 25, 'arkadaslik'),
    (68, 25, 1, 'arkadaslik'),
    (69, 2, 3, 'istegecevapbekleniyor'),
    (70, 3, 2, 'istegecevapverilecek'),
    (71, 2, 4, 'istegecevapbekleniyor'),
    (72, 4, 2, 'istegecevapverilecek'),
    (73, 2, 5, 'istegecevapbekleniyor'),
    (74, 5, 2, 'istegecevapverilecek'),
    (75, 2, 6, 'istegecevapbekleniyor'),
    (76, 6, 2, 'istegecevapverilecek'),
    (77, 2, 7, 'istegecevapbekleniyor'),
    (78, 7, 2, 'istegecevapverilecek'),
    (79, 2, 8, 'istegecevapbekleniyor'),
    (80, 8, 2, 'istegecevapverilecek'),
    (81, 2, 9, 'istegecevapbekleniyor'),
    (82, 9, 2, 'istegecevapverilecek');

ALTER TABLE `LOGINREQUESTS`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `POSTS`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `USERDETAILS`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `USERRELATIONS`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `LOGINREQUESTS` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 11;

ALTER TABLE `POSTS` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 47;

ALTER TABLE `USERDETAILS` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 17;

ALTER TABLE `USERRELATIONS` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 21;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;


/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;


/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;

