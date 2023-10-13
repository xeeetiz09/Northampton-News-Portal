SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `assignment1`
--
-- --------------------------------------------------------
--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(5) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp(),
  `admin_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `full_name`, `username`, `email`, `password`, `reg_date`, `admin_image`) VALUES
(1, 'Sujita Parajuli', 'sujita', 'sujitaparajuli@gmail.com', '3b6f3d0fc9d4cc902bb843d8a1900c485b0b4f3c', '2022-09-24 22:51:13', '');

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `category` varchar(100) NOT NULL,
  `publishDate` datetime NOT NULL DEFAULT current_timestamp(),
  `image` varchar(100) NOT NULL,
  `publishedBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `title`, `content`, `category`, `publishDate`, `image`, `publishedBy`) VALUES
(1, 'A WHOLE NEW INVENTION', 'Since the 1970s, flying automobiles have been hailed as the wave of the future, but despite numerous businesses claiming to have cracked the secret, they have only ever produced a few functional prototypes. Independent entrepreneurs like Terrafugia and PAL-V are now up against new competition from industry behemoths like Uber and Airbus in the quest to find a solution to the flying car dilemma.\r\nIn order to concentrate on the so-called \"Advanced Air Mobility market,\" Hyundai established a U.S.-based company called Supernal in November as part of its significant investment in the emerging sector. At the Farnborough International Airshow in England, Supernal has now shown its eVTOL Vehicle Cabin idea, showcasing a possible design for the passenger area of its planned intra-city air shuttle.', 'Automobiles', '2022-09-24 22:51:50', 'flyingCar.jpg', 'Sujita Parajuli'),
(2, 'AI IMAGE-GENERATION', 'The field of art is a new industry to add to the list as artificial intelligence continues to do tasks just as effectively as humans. OpenAI researchers have developed software that can produce graphics with only verbal inputs.\r\nYou can search for \"a dog wearing a cowboy hat singing in the rain\" and find a ton of absolutely unique pictures that suit the bill. Even the artistic style in which your request is returned is your choice. But there are still problems with the technology, like when we gave it bad instructions for drawing cartoon figures.\r\nThe team behind the Dall-E technology is now working on its second generation and has further development planned.', 'Technology', '2022-09-24 22:52:15', 'technology.jpeg', 'Sujita Parajuli'),
(3, 'HISTORY OF CRICKET', 'The field of art is a new industry to add to the list as artificial intelligence continues to do tasks just as effectively as humans. OpenAI researchers have developed software that can produce graphics with only verbal inputs.\r\nYou can search for \"a dog wearing a cowboy hat singing in the rain\" and find a ton of absolutely unique pictures that suit the bill. Even the artistic style in which your request is returned is your choice. But there are still problems with the technology, like when we gave it bad instructions for drawing cartoon figures.\r\nThe team behind the Dall-E technology is now working on its second generation and has further development planned.', 'Games', '2022-09-24 22:52:51', 'cricket.jpg', 'Sujita Parajuli'),
(4, 'REALISTIC HOLOGRAPHS', 'Holograms have long been a staple of science fiction literature, cinema, and popular culture, and while they do exist, they are still challenging to implement, especially on a wide scale. Holobricks, however, might be a technology that alters this.\r\n\r\nHolobricks are a method of tiling together several holograms to create a sizable, continuous 3D image. It was created by researchers from the University of Cambridge and Disney Research.\r\n\r\nThe problem with the majority of holograms today is the volume of data needed to create them, especially when done on a wide scale. Nearly 3TB every second of data would be need to create a hologram with a similar size and resolution, which is a significant quantity.', 'Technology', '2022-09-24 22:58:17', '', 'Sujita Parajuli'),
(5, 'BALENDRA SHAH - THE PRIDE OF NEPAL', 'Balendra Shah, also referred to as Balen Shah or simply Balen, is a politician and rapper from Nepal. He is now fifteenth mayor of Kathmandu, Nepal capital city.\r\nShah has gained popularity in Nepalese hip-hop since the beginning of the decade. Shah declared his candidacy as an independent and won the local election in 2022 by defeating Sirjana Singh of the Nepali Congress and Keshav Sthapit of the CPN (UML). He became the first independent candidate to become mayor of Kathmandu.\r\nShah was born in Naradevi, Kathmandu, on April 27, 1990. He is the youngest child of Ayurvedic doctor Ram Narayan Shah and his wife, Dhruvadevi Shah. After his father was assigned to Naradevi Ayurvedic Hospital, his parents relocated from Mahottari to Kathmandu.\r\nShah studied for his 10+2 years at V.S. Niketan Higher Secondary School. He graduated from Himalayan Whitehouse International College with a BE in civil engineering. A structural engineering masters degree (MTech) was also awarded to him by Visvesvaraya Technological University (VTU India) in the state of Karnataka.', 'Politics', '2022-09-24 23:14:12', 'balen.jpg', 'Sujita Parajuli');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(5) NOT NULL,
  `category` varchar(100) NOT NULL,
  `postedDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category`, `postedDate`) VALUES
(1, 'Entertainment', '2022-09-24 22:51:13'),
(2, 'Automobiles', '2022-09-24 22:51:13'),
(3, 'Technology', '2022-09-24 22:51:13'),
(4, 'Games', '2022-09-24 22:52:28'),
(5, 'Politics', '2022-09-24 22:54:37');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(5) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `commentText` varchar(200) NOT NULL,
  `newsId` int(5) NOT NULL,
  `comment_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(5) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp(),
  `user_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `full_name`, `username`, `email`, `password`, `reg_date`, `user_image`) VALUES
(1, 'Apshan Paudel', 'apshan', 'apshanpaudel@gmail.com', 'dfe4fa3c1965591cc105080ffe2def149fded9b8', '2022-09-24 22:51:13', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

