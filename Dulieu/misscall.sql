-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 13, 2022 lúc 11:02 AM
-- Phiên bản máy phục vụ: 10.4.24-MariaDB
-- Phiên bản PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `htqltuyensinh`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `misscall`
--

CREATE TABLE `misscall` (
  `MAMISSCALL` int(11) NOT NULL,
  `SDT` char(11) NOT NULL,
  `thoigian` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `misscall`
--

INSERT INTO `misscall` (`MAMISSCALL`, `SDT`, `thoigian`) VALUES
(4, '0999911115', '2022-07-07 15:48:05'),
(5, '0999911116', '2022-07-07 15:48:19'),
(9, '0999911120', '2022-07-07 16:24:40'),
(10, '0767026410', '2022-07-07 16:25:23'),
(13, '0999911118', '2022-07-12 11:15:11');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `misscall`
--
ALTER TABLE `misscall`
  ADD PRIMARY KEY (`MAMISSCALL`),
  ADD UNIQUE KEY `I_FK_MISSCALL_KHACHHANG` (`SDT`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `misscall`
--
ALTER TABLE `misscall`
  MODIFY `MAMISSCALL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `misscall`
--
ALTER TABLE `misscall`
  ADD CONSTRAINT `FK_MISSCALL_KHACHHANG` FOREIGN KEY (`SDT`) REFERENCES `khachhang` (`SDT`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
