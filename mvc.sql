--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `users` VALUES (1,NULL,'admin',NULL,'$2y$10$s0HYNDleEjBJBC0gBXEeoOmk/E/hlLbuXSpL9KoNY.gDJF106GUva',NULL),(2,NULL,'loll',NULL,'$2y$10$s0HYNDleEjBJBC0gBXEeoOmk/E/hlLbuXSpL9KoNY.gDJF106GUva',NULL),(3,NULL,'haha',NULL,'$2y$10$s0HYNDleEjBJBC0gBXEeoOmk/E/hlLbuXSpL9KoNY.gDJF106GUva',NULL);
