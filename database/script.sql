
--
-- Structure for messages table
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender` varchar(100) NOT NULL,
  `receiver` varchar(100) NOT NULL,
  `message` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for users table
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(255) NOT NULL DEFAULT 'assets/images/defaultImage.png',
  `session_id` varchar(255) NOT NULL DEFAULT '0',
  `connection_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Initial users data
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `password`, `profile_image`, `session_id`, `connection_id`) VALUES (1, 'test1', 'Test 1', 'test1@test.com', '$2y$10$wSbY8as51lILOocj7L9.duOF5/HeyBveTPES0KEW4Jks/YVwFxNiu', 'assets/images/defaultImage.png', 0, 0), (2, 'test2', 'Test 2', 'test2@test.com', '$2y$10$wSbY8as51lILOocj7L9.duOF5/HeyBveTPES0KEW4Jks/YVwFxNiu', 'assets/images/defaultImage.png', 0, 0);

--
-- Constraints for the above-created tables
--

ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

