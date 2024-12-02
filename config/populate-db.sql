USE LibraryDB;

INSERT INTO LIB_ITEM_TYPE (Name) VALUES 
('Book'),
('Audiobook'),
('Music'),
('Movie'),
('Magazine'),
('Periodical');

INSERT INTO LIB_MEDIA_TYPE (Name) VALUES
('Print'),
('Digital'),
('CD'),
('DVD'),
('Blu-Ray'),
('Vinyl'),
('Cassette'),
('Microform');

INSERT INTO LIB_GENRE (Name) VALUES
('Fiction'),
('Non-Fiction'),
('Science Fiction'),
('Fantasy'),
('Mystery'),
('Biography'),
('Historical'),
('Romance'),
('Horror'),
('Thriller'),
('Adventure'),
('Drama'),
('Comedy'),
('Action'),
('Documentary'),
('Children\'s'),
('Young Adult'),
('Music'),
('Poetry'),
('Crime'),
('Classic');

INSERT INTO LIB_CREATOR_TYPE (Name) VALUES
('Author'),
('Narrator'),
('Director'),
('Producer'),
('Musician'),
('Composer'),
('Artist'),
('Photographer'),
('Editor');

INSERT INTO LIB_PUBLISHER_TYPE (Name) VALUES
('Publisher'),
('Studio'),
('Record Label'),
('Magazine Publisher'),
('Distributor');

INSERT INTO LIB_FEE_TYPE (Name) VALUES
('Late'),
('Damage'),
('Lost'),
('Cleaning');

INSERT INTO LIB_ACCOUNT_TYPE (Name) VALUES
('Admin'),
('Staff'),
('Member');

INSERT INTO LIB_ROOM (Name, Capacity) VALUES
('Everest', 30),
('Amazon', 30),
('Sierra', 30),
('Kalahari', 60),
('Pacific', 80),
('Atlantic', 40),
('Arctic', 50),
('Savanna', 20),
('Andes', 35),
('Sahara', 80);


INSERT INTO LIB_CREATOR (Name, Gender, DateBorn, DateDied, Bio, ImagePath, CreatorTypeID) VALUES
('Mark Twain', 'M', '1835-11-30', '1910-04-21', 'Famous for works like Adventures of Huckleberry Finn and The Adventures of Tom Sawyer.', 'ImageDirectory/creator-img-1.webp', 1),
('J.K. Rowling', 'F', '1965-07-31', NULL, 'Best known for writing the Harry Potter series.', 'ImageDirectory/creator-img-2.png', 1),
('George Orwell', 'M', '1903-06-25', '1950-01-21', 'Famous for works such as 1984 and Animal Farm.', 'ImageDirectory/creator-img-3.jpg', 1),
('Maya Angelou', 'F', '1928-04-04', '2014-05-28', 'Known for her autobiographies and poetry, including I Know Why the Caged Bird Sings.', 'ImageDirectory/creator-img-4.jpg', 1),
('William Shakespeare', 'M', '1564-04-23', '1616-04-23', 'The iconic playwright, known for works like Romeo and Juliet, Macbeth, and Hamlet.', 'ImageDirectory/creator-img-5.jpg', 1), 
('Harper Lee', 'F', '1926-04-28', '2016-02-19', 'An American novelist whose 1960 novel To Kill a Mockingbird won the 1961 Pulitzer Prize and became a classic of modern American literature.', 'ImageDirectory/creator-img-6.webp', 1),
('Barbara A. Mowat', 'F', '1934-01-29', '2017-11-24', ' Director of Research emerita at the Folger Shakespeare Library, Consulting Editor of Shakespeare Quarterly, and author of The Dramaturgy of Shakespeare\'s Romances and of essays on Shakespeare\'s plays and their editing.', 'ImageDirectory/creator-img-7.jpg', 9),
('Paul Werstine', 'M', NULL, NULL, 'Professor Werstine has spent his career teaching Shakespeare and Medieval and Renaissance English Literature at King\'s University College.', 'ImageDirectory/creator-img-8.jpg', 9), 
('J.R.R. Tolkien', 'M', '1872-01-03', '1973-09-02', 'J.R.R. Tolkien was a British author, philologist, and academic, best known for creating the legendary fantasy works The Hobbit and The Lord of the Rings trilogy. Born in 1892 in Bloemfontein, South Africa, he grew up in England and developed a deep love for languages, which heavily influenced his world-building and storytelling. His richly imagined Middle-earth, complete with its own histories, cultures, and languages, has inspired generations of readers and shaped modern fantasy literature. A professor at Oxford University, Tolkien was also a scholar of Old English and medieval literature. His work remains a cornerstone of fantasy fiction, celebrated for its depth, moral complexity, and enduring themes of friendship and courage.', 'ImageDirectory/creator-img-JRR-Tolkien.webp', 1),
('Francis Ford Coppola', 'M', '1939-04-07', NULL, 'Acclaimed American director, producer, and screenwriter, known for directing The Godfather trilogy and Apocalypse Now.', 'ImageDirectory/creator-img-9.webp', 3),
('Christopher Nolan', 'M', '1970-07-30', NULL, 'British-American filmmaker known for his mind-bending narratives in films like Inception, Interstellar, and The Dark Knight trilogy.', 'ImageDirectory/creator-img-10.webp', 3),
('Michael Curtiz', 'M', '1886-12-24', '1962-04-10', 'Hungarian-American director famous for classic films like Casablanca and The Adventures of Robin Hood.', 'ImageDirectory/creator-img-11.jpg', 3),
('Frank Darabont', 'M', '1959-01-28', NULL, 'American director and screenwriter known for adapting Stephen King stories, including The Shawshank Redemption and The Green Mile.', 'ImageDirectory/creator-img-12.jpg', 3);

INSERT INTO LIB_PUBLISHER (Name, PublisherTypeID) VALUES
('Charles L. Webster & Co.', 1),
('Bloomsbury Publishing', 1),
('Secker & Warburg', 1),
('Random House', 1),
('Ballantine Books', 1), 
('Folger Shakespeare Library', 1), 
('William Morrow Paperbacks', 1),
('Columbia Pictures', 2),
('Paramount Pictures', 2),
('Warner Bros. Pictures', 2);


INSERT INTO LIB_ITEM (Isbn, Title, Description, Year, IssueNumber, LibCopies, ImagePath, LibLocation, ItemTypeID, MediaTypeID, GenreID) VALUES
('9783161484100','Adventures of Huckleberry Finn', 'A novel by Mark Twain that chronicles the adventures of a young boy and an escaped slave.', 1884, 1, 2, 'ImageDirectory/item-img-1.jpg', 'FIC TWA 813.4', 1, 1, 21),
('9780590353403','Harry Potter and the Sorcerer\'s Stone', 'J.K. Rowling\'s fantasy novel about a young wizard attending Hogwarts School of Witchcraft and Wizardry.', 1997, 1, 1, 'ImageDirectory/item-img-2.jpg', 'FIC ROW 823.914', 1, 1, 4),
('9780590471151','Harry Potter and the Chamber of Secrets', 'J.K. Rowling\'s second book in the Harry Potter series, where Harry faces new challenges at Hogwarts.', 1998, 2, 2, 'ImageDirectory/item-img-3.jpg', 'FIC ROW 823.914', 1, 1, 4),
('9780590471168','Harry Potter and the Prisoner of Azkaban', 'The third novel in the Harry Potter series, where Harry learns more about his family\'s dark secrets.', 1999, 3, 2, 'ImageDirectory/item-img-4.jpg', 'FIC LEE 813.54', 1, 1, 4),
('9780061120084','To Kill a Mockingbird', 'Harper Lee\'s Pulitzer Prize-winning novel that explores racial injustice in the American South.', 1960, 1, 3, 'ImageDirectory/item-img-5.jpg', 'FIC ORW 823.912', 1, 1, 21),
('9780452284234','1984', 'George Orwell\'s dystopian novel about a totalitarian regime that uses surveillance and mind control to oppress the masses.', 1949, 1, 1, 'ImageDirectory/item-img-6.jpg', 'FIC TWA 813.4', 1, 1, 1),
('9781853263364','The Taming of the Shrew', 'A comedy by William Shakespeare about a man who tries to tame his strong-willed wife.', 1590, 1, 1, 'ImageDirectory/item-img-7.jpg', '822.33 SHA', 1, 1, 21),
('9781853263326','Macbeth', 'A tragedy by William Shakespeare about the destructive effects of ambition on Macbeth and Lady Macbeth.', 1606, 1, 1, 'ImageDirectory/item-img-8.jpg', '822.33 SHA', 1, 1, 21),
('9780345530016','I Know Why the Caged Bird Sings', 'Maya Angelou\'s autobiography that reflects her early life and the challenges she faced growing up.', 1969, 1, 1, 'ImageDirectory/item-img-9.jpg', '921 ANG', 1, 1, 6),
('9780345530023','Gather Together in My Name', 'Maya Angelou\'s second autobiography about the complexities of womanhood, motherhood, and self-discovery.', 1974, 1, 1, 'ImageDirectory/item-img-10.jpg', '921 ANG', 1, 1, 6),
('9780547928210','The Fellowship of the Ring: The Lord of the Rings', 'Frodo Baggins inherits the One Ring, a powerful and corrupt artifact sought by the dark lord Sauron. To prevent Sauron\'s rise, Frodo embarks on a perilous journey to destroy the Ring, joined by a diverse fellowship of allies, including hobbits, a wizard, an elf, a dwarf, and men.', 1954, 1, 4, 'ImageDirectory/item-img-fellowship.jpg', 'FIC 814.63 JR', 1, 1, 1),
('9780547928203','The Two Towers: The Lord of the Rings', 'The journey of Frodo and Sam continue as they venture toward Mordor to destroy the One Ring, guided by the treacherous creature Gollum. Meanwhile, Aragorn, Legolas, and Gimli pursue their kidnapped friends, Merry and Pippin, leading to battles against the forces of Saruman and the defense of Rohan at Helm\'s Deep.', 1954, 1, 3, 'ImageDirectory/item-img-two-towers.jpg', 'FIC 814.80 JR', 1, 1, 1), 
(NULL, 'The Shawshank Redemption', 'A drama about two imprisoned men who bond over several years, finding solace and redemption.', 1994, 1, 3, 'ImageDirectory/item-img-shawshank.jpg', 'DVD SHA 791.43', 4, 4, 12),
(NULL, 'The Godfather', 'The epic tale of a 1940s New York Mafia family and their struggle to protect their empire.', 1972, 1, 2, 'ImageDirectory/item-img-godfather.jpg', 'DVD GOD 791.43', 4, 4, 20),
(NULL, 'Inception', 'A sci-fi thriller about a thief who steals corporate secrets through the use of dream-sharing technology.', 2010, 1, 4, 'ImageDirectory/item-img-inception.jpg', 'DVD INC 791.43', 4, 5, 10),
(NULL, 'Casablanca', 'A classic romance set in WWII-era Morocco, where a man must choose between love and virtue.', 1942, 1, 3, 'ImageDirectory/item-img-casablanca.jpg', 'DVD CAS 791.43', 4, 4, 8),
(NULL, 'The Dark Knight', 'A gritty action film about Batman facing his greatest adversary, the Joker, in a battle for Gotham.', 2008, 1, 5, 'ImageDirectory/item-img-dark-knight.jpg', 'DVD DAR 791.43', 4, 5, 13);

INSERT INTO LIB_ITEM_CREATOR (ItemID, CreatorID) VALUES
(1, 1), -- "Adventures of Huckleberry Finn" by Mark Twain
(2, 2), -- "Harry Potter and the Sorcerer's Stone" by J.K. Rowling
(3, 2), -- "Harry Potter and the Chamber of Secrets" by J.K. Rowling
(4, 2), -- "Harry Potter and the Prisoner of Azkaban" by J.K. Rowling
(5, 6), -- "To Kill a Mockingbird" by Harper Lee
(6, 3), -- "1984" by George Orwell
(7, 5), -- "The Taming of the Shrew" by William Shakespeare
(7, 7), -- "The Taming of the Shrew" edited by Barbara A. Mowat
(7, 8), -- "The Taming of the Shrew" edited by Paul Werstine
(8, 5), -- "Macbeth" by William Shakespeare
(8, 7), -- "Macbeth" edited by Barbara A. Mowat
(8, 8), -- "Macbeth" edited by Paul Werstine
(9, 4), -- "I Know Why the Caged Bird Sings" by Maya Angelou
(10, 4), -- "Gather Together in My Name" by Maya Angelou
(11, 9), -- "Fellowship of the Ring" by J.R.R. Tolkien
(12, 9), -- "The Two Towers" by J.R.R. Tolkien
(13, 12), -- "The Shawshank Redemption" directed by Frank Darabont
(14, 10), -- "The Godfather" directed by Francis Ford Coppola
(15, 11), -- "Inception" directed by Christopher Nolan
(16, 13), -- "Casablanca" directed by Michael Curtiz
(17, 11); -- "The Dark Knight" directed by Christopher Nolan
;

INSERT INTO LIB_ITEM_PUBLISHER (ItemID, PublisherID) VALUES
(1, 1), -- "Adventures of Huckleberry Finn" by Charles L. Webster & Co.
(2, 2), -- "Harry Potter and the Sorcerer's Stone" by Bloomsbury Publishing
(3, 2), -- "Harry Potter and the Chamber of Secrets" by Bloomsbury Publishing
(4, 2), -- "Harry Potter and the Prisoner of Azkaban" by Bloomsbury Publishing
(5, 4), -- "To Kill a Mockingbird" by Random House
(6, 3), -- "1984" by Secker & Warburg
(7, 6), -- "The Taming of the Shrew" by Folger Shapespeare Library
(8, 6), -- "Macbeth" by Folger Shapespeare Library
(9, 5), -- "I Know Why the Caged Bird Sings" by Ballantine Books
(10, 4), -- "Gather Together in My Name" by Random House
(11, 7), -- "Fellowship of the Ring" by J.R.R. Tolkien
(12, 7), -- "The Two Towers" by J.R.R. Tolkien
(13, 8), -- "The Shawshank Redemption" by Columbia Pictures
(14, 9), -- "The Godfather" by Paramount Pictures
(15, 10), -- "Inception" by Warner Bros. Pictures
(16, 10), -- "Casablanca" by Warner Bros. Pictures
(17, 10); -- "The Dark Knight" by Warner Bros. Pictures

INSERT INTO LIB_INSTRUCTOR (Name, Gender, Bio, ImagePath) VALUES
('Dr. John Doe', 'M', 'Dr. John Doe is an experienced educator with a passion for literature and history. He has been teaching for over 20 years and specializes in American and English literature.', 'ImageDirectory/instructor-img-1.jpg'),
('Prof. Jane Smith', 'F', 'Professor Jane Smith is a renowned scholar in the field of modern European history. With a focus on 20th-century events, she brings a wealth of knowledge and experience to her students.', 'ImageDirectory/instructor-img-4.jpg'),
('Ms. Rachel Boone', 'F', 'Miss Rachel is a creative art instructor who loves inspiring kids and moms to explore painting together in a fun and interactive way.', 'ImageDirectory/instructor-img-3.jpg'),
('Dr. Emily White', 'F', 'Dr. Emily White holds a PhD in Comparative Literature and has a deep interest in cultural studies. She has written several papers on post-colonial literature and teaches courses on global literary traditions.', 'ImageDirectory/instructor-img-2.jpg');

-- Insert sample class records
INSERT INTO LIB_CLASS (Title, Description, DurationMins, ImagePath) VALUES
('Mommy and Me Art', 'A fun and creative art class designed for children and their mothers. Participants will explore various art techniques such as drawing, painting, and crafting in a supportive, hands-on environment.', 30, 'ImageDirectory/class-img-5.jpg'),
('Creative Writing', 'A writing class tailored for adults looking to express themselves through storytelling, poetry, and essays. Focus will be on developing writing skills and finding your unique voice.', 45, 'ImageDirectory/class-img-4.avif'),
('Digital Photography Basics', 'Learn the fundamentals of digital photography, including camera settings, composition, and lighting. This class is perfect for beginners who want to improve their photography skills.', 60, 'ImageDirectory/class-img-3.png'),
('Introduction to Coding', 'This class provides a beginner-friendly introduction to coding using easy-to-understand languages. Perfect for those looking to start their tech journey with no prior experience.', 60, 'ImageDirectory/class-img-2.avif'),
('Mindfulness and Meditation', 'Join us for a relaxing class focused on mindfulness techniques, meditation practices, and stress management. Ideal for anyone looking to improve mental well-being and find calm in daily life.', 30, 'ImageDirectory/class-img-1.webp');

-- Insert sample event records
INSERT INTO LIB_EVENT (Title, Description, ImagePath) VALUES
('Holiday Craft Session', 'Create your own Christmas ornament! Join us for a festive crafting session.', 'ImageDirectory/event-img-1.webp'),
('Book Fair', 'Explore a wide range of books at our annual book fair. All genres, all ages!', 'ImageDirectory/book-fair.jpg'),
('Local History Day: Ogden, Utah', 'Discover the rich history of our local area through stories, exhibits, and guest speakers.', 'ImageDirectory/event-img-2.jpg'),
('Movie Night: Night at the Museum', 'Join us for a fun family movie night featuring \'Night at the Museum\'.', 'ImageDirectory/event-img-3.jpg'),
('Story Hour', 'Bring the kids for a delightful story hour filled with fun and imagination. Perfect for children of all ages!', 'ImageDirectory/story-hour.jpg');

INSERT INTO LIB_EVENT_SCHEDULE (Date, Time, EventID, RoomID) VALUES
('2024-12-09', '16:00:00', 1, 2), -- Holiday Craft Session in Amazon
('2024-11-15', '10:00:00', 2, 5), -- Book Fair in Pacific
('2024-11-10', '14:00:00', 3, 4), -- Local History Day in Kalahari
('2024-11-18', '18:00:00', 4, 3), -- Movie Night in Sierra
('2024-11-07', '11:00:00', 5, 1), -- November Story Hour in Everest
('2024-12-12', '11:00:00', 5, 1); -- December Story Hour in Everest

INSERT INTO LIB_CLASS_INSTRUCTOR (ClassID, InstructorID) VALUES
(2, 1), -- Creative Writing for Adults with Dr. John Doe
(3, 2), -- Digital Photography Basics with Prof. Jane Smith
(1, 3), -- Art for Kids and Moms with Ms. Rachel Boone
(4, 2), -- Introduction to Coding with Prof. Jane Smith
(5, 4); -- Mindfulness and Meditation with Dr. Emily White

INSERT INTO LIB_CLASS_SCHEDULE (Date, Time, ClassID, RoomID) VALUES
-- Creative Writing for Adults (Day Class)
('2024-09-03', '10:00:00', 2, 1), -- Everest
('2024-09-10', '10:00:00', 2, 1),
('2024-09-17', '10:00:00', 2, 1),
('2024-09-24', '10:00:00', 2, 1),
('2024-10-01', '10:00:00', 2, 1),
('2024-10-08', '10:00:00', 2, 1),
('2024-10-15', '10:00:00', 2, 1),
('2024-10-22', '10:00:00', 2, 1),
('2024-10-29', '10:00:00', 2, 1),
('2024-11-05', '10:00:00', 2, 1),
('2024-11-12', '10:00:00', 2, 1),
('2024-11-19', '10:00:00', 2, 1),
('2024-11-26', '10:00:00', 2, 1),
('2024-12-03', '10:00:00', 2, 1),

-- Art for Kids and Moms (Day Class)
('2024-09-05', '14:00:00', 1, 2), -- Amazon
('2024-09-12', '14:00:00', 1, 2),
('2024-09-19', '14:00:00', 1, 2),
('2024-09-26', '14:00:00', 1, 2),
('2024-10-03', '14:00:00', 1, 2),
('2024-10-10', '14:00:00', 1, 2),
('2024-10-17', '14:00:00', 1, 2),
('2024-10-24', '14:00:00', 1, 2),
('2024-10-31', '14:00:00', 1, 2),
('2024-11-07', '14:00:00', 1, 2),
('2024-11-14', '14:00:00', 1, 2),
('2024-11-21', '14:00:00', 1, 2),
('2024-12-05', '14:00:00', 1, 2),

-- Digital Photography Basics (Evening Class)
('2024-09-04', '18:00:00', 3, 3), -- Sierra
('2024-09-11', '18:00:00', 3, 3),
('2024-09-18', '18:00:00', 3, 3),
('2024-09-25', '18:00:00', 3, 3),
('2024-10-02', '18:00:00', 3, 3),
('2024-10-09', '18:00:00', 3, 3),
('2024-10-16', '18:00:00', 3, 3),
('2024-10-23', '18:00:00', 3, 3),
('2024-10-30', '18:00:00', 3, 3),
('2024-11-06', '18:00:00', 3, 3),
('2024-11-13', '18:00:00', 3, 3),
('2024-11-20', '18:00:00', 3, 3),
('2024-12-04', '18:00:00', 3, 3),

-- Introduction to Coding (Evening Class)
('2024-09-06', '19:00:00', 4, 4), -- Kalahari
('2024-09-13', '19:00:00', 4, 4),
('2024-09-20', '19:00:00', 4, 4),
('2024-09-27', '19:00:00', 4, 4),
('2024-10-04', '19:00:00', 4, 4),
('2024-10-11', '19:00:00', 4, 4),
('2024-10-18', '19:00:00', 4, 4),
('2024-10-25', '19:00:00', 4, 4),
('2024-11-01', '19:00:00', 4, 4),
('2024-11-08', '19:00:00', 4, 4),
('2024-11-15', '19:00:00', 4, 4),
('2024-11-22', '19:00:00', 4, 4),
('2024-12-06', '19:00:00', 4, 4),

-- Mindfulness and Meditation (Evening Class)
('2024-09-07', '18:30:00', 5, 5), -- Pacific
('2024-09-14', '18:30:00', 5, 5),
('2024-09-21', '18:30:00', 5, 5),
('2024-09-28', '18:30:00', 5, 5),
('2024-10-05', '18:30:00', 5, 5),
('2024-10-12', '18:30:00', 5, 5),
('2024-10-19', '18:30:00', 5, 5),
('2024-10-26', '18:30:00', 5, 5),
('2024-11-02', '18:30:00', 5, 5),
('2024-11-09', '18:30:00', 5, 5),
('2024-11-16', '18:30:00', 5, 5),
('2024-11-23', '18:30:00', 5, 5),
('2024-12-07', '18:30:00', 5, 5);

/*
* All user passwords follow this format
*   > First initial + last name + '123!'
*   > Example: 'ajohnson123!'
*/
INSERT INTO LIB_ACCOUNT (FirstName, LastName, Phone, Email, Street, City, State, Zip, StartDate, Username, Password, AccountTypeID) VALUES
-- Admin User
('Alice', 'Johnson', '801-123-4567', 'alice.johnson@example.com', '123 Library St.', 'Salt Lake City', 'UT', '84101', '2024-01-01', 'ajohnson', '$2y$10$lCh5Lp4vYzJ80/lj1/UCPe1PwyFsszBNv9Drq41Qo/98KDzr2RRMu', 1),

-- Staff Users
('Bob', 'Smith', '801-234-5678', 'bob.smith@example.com', '456 Page Ave.', 'Salt Lake City', 'UT', '84102', '2024-01-02', 'bsmith', '$2y$10$ZzUu4b8EMbqnypuIxoblYOJVzX4x5BDt.Fu1JWBmIUUxr4VzJFKJu', 2),
('Carol', 'Taylor', '801-345-6789', 'carol.taylor@example.com', '789 Chapter Ln.', 'Salt Lake City', 'UT', '84103', '2024-01-03', 'ctaylor', '$2y$10$jLOhvJV/zUM2X9PCRnd2weW0hXhoG0o7qPwZc4sAQjqhnadUpNsNK', 2),
('Dan', 'Brown', '801-456-7890', 'dan.brown@example.com', '101 Story Rd.', 'Salt Lake City', 'UT', '84104', '2024-01-04', 'dbrown', '$2y$10$UolzFHG4xtkVGooRHqeH1.Z6gZj7BPZ1UPFtSD5Y/3bqKDjzxUCY.', 2),

-- Member Users
('Paula', 'Jones', '801-567-8901', 'paula.jones@example.com', '202 Verse Blvd.', 'Salt Lake City', 'UT', '84105', '2024-01-05', 'pjones', '$2y$10$0BnyHa63WI0Zd3GFHGsnMeoFKKksktJi/dx0Ir2R567MXJLysvBbi', 3),
('Frank', 'Wilson', '801-678-9012', 'frank.wilson@example.com', '303 Epic St.', 'Salt Lake City', 'UT', '84106', '2024-01-06', 'fwilson', '$2y$10$8mqjh9vtnAdpgR302XCkcejCRvIsJzscTgyN/0aIYU606JKwh0O5u', 3),
('Grace', 'Miller', '801-789-0123', 'grace.miller@example.com', '404 Tale Rd.', 'Salt Lake City', 'UT', '84107', '2024-01-07', 'gmilller', '$2y$10$wFoB6hdWMh1iZpMDsXtExujNw.XUt72w13tEpqrsgqjiU.9rAerPu', 3),
('Hank', 'Moore', '801-890-1234', 'hank.moore@example.com', '505 Narrative Dr.', 'Salt Lake City', 'UT', '84108', '2024-01-08', 'hmoore', '$2y$10$cs5829o0LISQ0I1jo2HusO4F8CREwMFi.QsLRoCNMvSYyFfFtge3K', 3),
('Ivy', 'Lee', '801-901-2345', 'ivy.lee@example.com', '606 Chronicle Ave.', 'Salt Lake City', 'UT', '84109', '2024-01-09', 'ilee', '$2y$10$IX6jRXJzHOp2OGO1v.8uO.2MK55QeRDnulRIBHHSou9mw/6Ts/lgi', 3),
('Jack', 'White', '801-012-3456', 'jack.white@example.com', '707 Legend Ln.', 'Salt Lake City', 'UT', '84110', '2024-01-10', 'jwhite', '$2y$10$AxuyLeavLr5zx37Xdhls2.42eHxTaaUqlD5rU/LKWp5fo6/ODa3DG', 3),
('John', 'Smith', '801-234-5678', 'john.smith@example.com', '123 Maple St.', 'Salt Lake City', 'UT', '84101', '2024-01-10', 'jsmith', '$2y$10$0vj12HCSnMAyb7CRT2NwHO.V07MsPiLf4p6g.CUpANY7Ue4rUiGtu', 3),
('Emily', 'Johnson', '801-345-6789', 'emily.johnson@example.com', '456 Oak Ave.', 'Salt Lake City', 'UT', '84102', '2024-01-11', 'ejohnson', '$2y$10$FSKjX8KdIh3PMAh05HyEZu0TUbfUbYTtnwK1Z7vppqbn8x3yEi9/S', 3),
('Michael', 'Brown', '801-456-7890', 'michael.brown@example.com', '789 Pine Dr.', 'Salt Lake City', 'UT', '84103', '2024-01-12', 'mbrown', '$2y$10$.QvV/RfzM/IthF4t0V4FvOQjc5GFdyiKJ..oeSDfHSmsPoJOBP2nK', 3),
('Sarah', 'Davis', '801-567-8901', 'sarah.davis@example.com', '101 Birch Rd.', 'Salt Lake City', 'UT', '84104', '2024-01-13', 'sdavis', '$2y$10$85DCyNa/ZmDaw90SuvsrrOCp/5hHi3d3Fq6grfy5NHy5GZqIN5mA6', 3),
('Christopher', 'Martinez', '801-678-9012', 'christopher.martinez@example.com', '202 Cedar Ln.', 'Salt Lake City', 'UT', '84105', '2024-01-14', 'cmartinez', '$2y$10$yD7QBECC1jKoKStm89XGrOxWGnK.k8Ls.vIYPn/8qrJQbKdnwjkca', 3),
('Jessica', 'Garcia', '801-789-0123', 'jessica.garcia@example.com', '303 Spruce Ct.', 'Salt Lake City', 'UT', '84106', '2024-01-15', 'jgarcia', '$2y$10$SR86blqGHFbUqu5L0o2ss.aGPQSS7UzPqUO6il.MsuVT8f1YmO72S', 3),
('Daniel', 'Rodriguez', '801-890-1234', 'daniel.rodriguez@example.com', '404 Elm Blvd.', 'Salt Lake City', 'UT', '84107', '2024-01-16', 'drodriguez', '$2y$10$8C9EF2WEM4gukvc.v6.8BenCL0sEZIxDHjbQSNTXhqqOlc7EiCxuy', 3),
('Amanda', 'Lopez', '801-901-2345', 'amanda.lopez@example.com', '505 Walnut Pl.', 'Salt Lake City', 'UT', '84108', '2024-01-17', 'alopez', '$2y$10$Bw01drD4JcQx6MpuobDtOOPQN.8rbQgzpstjfRI8yROpHMvBNWrqi', 3),
('Joshua', 'Hernandez', '801-012-3456', 'joshua.hernandez@example.com', '606 Aspen Way', 'Salt Lake City', 'UT', '84109', '2024-01-18', 'jhernandez', '$2y$10$MG9H7WKowKXT1qTo83J6ReGDneZRT2TxwpmnJP53UuAjoPWCjr7Iy', 3),
('Brittany', 'Moore', '801-123-4567', 'brittany.moore@example.com', '707 Willow St.', 'Salt Lake City', 'UT', '84110', '2024-01-19', 'bmoore', '$2y$10$d3.tFqk4lgXsfeXCy15vsefF0XOF7HJ8U6Ktkd7haRaRKPP0y7jdm', 3),
('Andrew', 'Clark', '801-234-5678', 'andrew.clark@example.com', '808 Poplar Dr.', 'Salt Lake City', 'UT', '84111', '2024-01-20', 'aclark', '$2y$10$53VjnPs0W15G4jRojQkbseNLeLJLPNw5GYqWxWFsD56QCoV5T46ge', 3),
('Laura', 'Lewis', '801-345-6789', 'laura.lewis@example.com', '909 Cherry Ln.', 'Salt Lake City', 'UT', '84112', '2024-01-21', 'llewis', '$2y$10$mZbAefbulCXyW.a3kRZ73eYUacpjodfE8Msw9yZgEpMcfVclZtB62', 3),
('Justin', 'Hall', '801-456-7890', 'justin.hall@example.com', '1010 Beech Ct.', 'Salt Lake City', 'UT', '84113', '2024-01-22', 'jhall', '$2y$10$375u728sy01TRSwooj5PbeqZfg3n4gl9RSU.xrXUMbqxlQh/2zfjq', 3),
('Nicole', 'Adams', '801-567-8901', 'nicole.adams@example.com', '1111 Sycamore Rd.', 'Salt Lake City', 'UT', '84114', '2024-01-23', 'nadams', '$2y$10$JbIcXM2GiHN/YFFVMs2Te.9.QfRt/.esqQsZU1B25QhwNymcSyn1O', 3),
('Matthew', 'Walker', '801-678-9012', 'matthew.walker@example.com', '1212 Cypress Ave.', 'Salt Lake City', 'UT', '84115', '2024-01-24', 'mwalker', '$2y$10$aq3reduo5x3N8pguxLnaUOKcHgT2hdy3uliKmEniPK43HKWAt9mVC', 3),
('Hannah', 'Hill', '801-789-0123', 'hannah.hill@example.com', '1313 Magnolia Blvd.', 'Salt Lake City', 'UT', '84116', '2024-01-25', 'hhill', '$2y$10$l8N0pIAH5zrR8sfiC4CAt.HyhFAX0rFeSGnSLgF5j/jh8lm2pU/hy', 3), 
('Olivia', 'Scott', '801-890-1234', 'olivia.scott@example.com', '1414 Redwood Dr.', 'Salt Lake City', 'UT', '84117', '2024-01-26', 'oscott', '$2y$10$27YopGgKi/muv9uv3gHv1e81MaOjqQpVJRldUECioRnpqBo7rf.Li', 3),
('Ethan', 'Green', '801-901-2345', 'ethan.green@example.com', '1515 Pine Hill Rd.', 'Salt Lake City', 'UT', '84118', '2024-01-27', 'egreen', '$2y$10$BCfLO2waZT4q9xBgoyUSI.LVr17g2E2skov/EIXyreUOc7VyQFrxu', 3),
('Avery', 'Young', '801-012-3456', 'avery.young@example.com', '1616 Riverbend Dr.', 'Salt Lake City', 'UT', '84119', '2024-01-28', 'ayoung', '$2y$10$9X510YvKx1Rf77e0siR2XOjtNqeu6I4fUaGoCIAsVwvjJ.j0ns4f.', 3),
('Benjamin', 'King', '801-123-4567', 'benjamin.king@example.com', '1717 Summit Ave.', 'Salt Lake City', 'UT', '84120', '2024-01-29', 'bking', '$2y$10$bUCiy9/c/MCtrDmuND0bseIC8WAEmP.Kr9m3LgKm3KaX4dYddsDae', 3),
('Megan', 'Wright', '801-234-5678', 'megan.wright@example.com', '1818 Canyon Dr.', 'Salt Lake City', 'UT', '84121', '2024-01-30', 'mwright', '$2y$10$wmqEKiQHmF8B11RWWfKH5O4Beerr6/s5IqUZ5P2jerqY3.mYK65ue', 3),
('James', 'Lopez', '801-345-6789', 'james.lopez@example.com', '1919 Maple St.', 'Salt Lake City', 'UT', '84122', '2024-01-31', 'jlopez', '$2y$10$f27zMaknKZRZzg.enetF.OkrffT0ZM/m98Jl75R0xd2v5Mx14/ZkG', 3),
('Sophia', 'Gonzalez', '801-456-7890', 'sophia.gonzalez@example.com', '2020 Pinecrest Rd.', 'Salt Lake City', 'UT', '84123', '2024-02-01', 'sgonzalez', '$2y$10$RUof9wy8Xeze/Dul5293ee9hMJmQ4BxC5akjWfx2I03QjLYs72nbC', 3),
('Lucas', 'Nelson', '801-567-8901', 'lucas.nelson@example.com', '2121 River Dr.', 'Salt Lake City', 'UT', '84124', '2024-02-02', 'lnelson', '$2y$10$vnjQGU2vnnPCwQUiAdXZGeGR8UWNVCdeoQHXdPszWc6QcSV2o4YkG', 3),
('Chloe', 'Adams', '801-678-9012', 'chloe.adams@example.com', '2222 Highland Blvd.', 'Salt Lake City', 'UT', '84125', '2024-02-03', 'cadams', '$2y$10$htd8S6v.G3zgM/Gua9jZpe8IZi24.8JA4iQ8fNMrMi28oLptXzo2a', 3),
('Jack', 'Baker', '801-789-0123', 'jack.baker@example.com', '2323 Meadow Ln.', 'Salt Lake City', 'UT', '84126', '2024-02-04', 'jbaker', '$2y$10$iWDOab7wRQ3qd.Seex4jrefnfeGTX1hXHIM5DJ5r1aQtUc9W26nXK', 3),
('Zoe', 'Parker', '801-890-1234', 'zoe.parker@example.com', '2424 Greenfield Dr.', 'Salt Lake City', 'UT', '84127', '2024-02-05', 'zparker', '$2y$10$GjIQUizMrA6orTywHGQAa.rb0u0rIv3zqD6IxBZg6eDDQDDcjF.Q2', 3),
('Matthew', 'Evans', '801-901-2345', 'matthew.evans@example.com', '2525 Ridge Rd.', 'Salt Lake City', 'UT', '84128', '2024-02-06', 'mevans', '$2y$10$b71xUXTzy.713hJzjIU3i.u5.96ik7deAy3XRTEvph170gQA/Rifa', 3),
('Samantha', 'Carter', '801-012-3456', 'samantha.carter@example.com', '2626 Woodland Ave.', 'Salt Lake City', 'UT', '84129', '2024-02-07', 'scarter', '$2y$10$QDC1aBZnFC7EBeoS5nv2BOcJ7pe6XxPIo9YB7nLJzOVI8mbAFPZou', 3),
('Benjamin', 'Mitchell', '801-123-4567', 'benjamin.mitchell@example.com', '2727 Lakeshore Dr.', 'Salt Lake City', 'UT', '84130', '2024-02-08', 'bmitchell', '$2y$10$JpfkgaB6ZmGTODOF/LhC2umjC.y9Zib5sUqsPTNgeOx7av5WIFzpi', 3),
('Ava', 'Roberts', '801-234-5678', 'ava.roberts@example.com', '2828 Desert Rd.', 'Salt Lake City', 'UT', '84131', '2024-02-09', 'aroberts', '$2y$10$t9QpJtBeP3f328iPStqONeCxb6V.bIUpYwQUQ.TUAk9g2VV62rOzC', 3)
;


INSERT INTO LIB_CHECKOUT (AccountID, CheckoutDate, DueDate, ReturnDate) VALUES
(1, '2024-04-09', '2024-05-03', '2024-05-09'),
(3, '2024-08-25', '2024-09-12', '2024-09-01'),
(3, '2024-07-16', '2024-08-03', NULL),
(3, '2024-06-19', '2024-07-05', '2024-06-27'),
(4, '2024-06-19', '2024-07-15', NULL),
(4, '2024-01-17', '2024-02-05', NULL),
(5, '2024-10-23', '2024-11-15', '2024-11-24'),
(5, '2024-11-06', '2024-11-17', '2024-11-07'),
(5, '2024-09-03', '2024-09-10', NULL),
(5, '2024-09-25', '2024-10-10', NULL),
(6, '2024-04-09', '2024-05-03', '2024-05-04'),
(6, '2024-06-18', '2024-07-04', NULL),
(7, '2024-02-01', '2024-02-12', NULL),
(8, '2024-08-05', '2024-08-23', '2024-08-19'),
(8, '2024-09-10', '2024-09-21', '2024-09-11'),
(9, '2024-03-15', '2024-04-05', '2024-03-20'),
(10, '2024-07-06', '2024-07-28', NULL),
(11, '2024-10-07', '2024-10-28', '2024-10-26'),
(11, '2024-12-01', '2024-12-16', '2024-12-15'),
(12, '2024-05-21', '2024-06-07', NULL),
(13, '2024-03-13', '2024-03-29', '2024-03-18'),
(14, '2024-07-05', '2024-07-19', '2024-07-12'),
(14, '2024-09-17', '2024-10-01', NULL),
(16, '2024-02-25', '2024-03-11', '2024-03-01'),
(17, '2024-04-20', '2024-05-10', '2024-05-07'),
(18, '2024-03-30', '2024-04-15', NULL),
(18, '2024-07-11', '2024-07-29', '2024-07-22'),
(19, '2024-11-23', '2024-12-14', '2024-12-12'),
(20, '2024-08-10', '2024-08-29', NULL),
(21, '2024-10-02', '2024-10-20', '2024-10-15'),
(21, '2024-12-13', '2024-12-30', NULL),
(22, '2024-04-15', '2024-04-28', '2024-04-20'),
(23, '2024-01-28', '2024-02-12', '2024-02-10'),
(23, '2024-05-11', '2024-05-27', NULL),
(24, '2024-02-15', '2024-03-05', '2024-03-01'),
(24, '2024-06-25', '2024-07-10', NULL),
(25, '2024-07-07', '2024-07-24', '2024-07-20'),
(28, '2024-03-18', '2024-03-31', NULL),
(28, '2024-09-24', '2024-10-13', '2024-09-28'),
(29, '2024-04-10', '2024-04-30', NULL),
(30, '2024-02-17', '2024-03-03', '2024-03-02'),
(31, '2024-06-23', '2024-07-10', '2024-07-02'),
(31, '2024-12-10', '2024-12-27', '2024-12-26'),
(32, '2024-09-06', '2024-09-27', NULL),
(33, '2024-11-03', '2024-11-19', '2024-11-07'),
(33, '2024-12-05', '2024-12-21', NULL),
(34, '2024-01-07', '2024-01-17', NULL),
(35, '2024-05-12', '2024-05-27', '2024-05-23'),
(36, '2024-03-09', '2024-03-27', NULL),
(37, '2024-10-01', '2024-10-20', '2024-10-12'),
(39, '2024-04-11', '2024-04-27', '2024-04-22'),
(40, '2024-11-12', '2024-12-10', '2024-11-14');


INSERT INTO LIB_CHECKOUT_ITEM (CheckoutID, ItemID) VALUES
(1, 12),
(2, 12),
(2, 15),
(3, 14),
(3, 16),
(4, 17),
(5, 14),
(6, 7),
(6, 3),
(7, 16),
(8, 5),
(9, 13),
(9, 3),
(9, 6),
(10, 11),
(10, 15),
(10, 12),
(11, 10),
(11, 4),
(11, 13),
(12, 13),
(13, 17),
(14, 6),
(14, 13),
(14, 3),
(15, 3),
(16, 8),
(17, 7),
(17, 11),
(18, 11),
(18, 13),
(19, 4),
(19, 1),
(19, 11),
(20, 9),
(20, 17),
(21, 13),
(21, 12),
(22, 14),
(22, 1),
(22, 2),
(23, 12),
(23, 13),
(23, 7),
(24, 7),
(25, 3),
(25, 10),
(26, 4),
(27, 16),
(27, 2),
(27, 9),
(28, 10),
(28, 7),
(28, 6),
(29, 1),
(29, 3),
(29, 17),
(30, 4),
(30, 5),
(30, 8),
(31, 9),
(31, 5),
(31, 16),
(32, 11),
(32, 7),
(32, 8),
(33, 15),
(33, 3),
(33, 5),
(34, 9),
(34, 13),
(35, 8),
(35, 10),
(35, 17),
(36, 2),
(36, 17),
(36, 14),
(37, 14),
(37, 10),
(38, 16),
(38, 12),
(38, 7),
(39, 4),
(40, 17),
(40, 6),
(41, 14),
(41, 3),
(42, 5),
(42, 2),
(42, 17),
(43, 15),
(43, 8),
(43, 10),
(44, 17),
(45, 6),
(46, 3),
(46, 5),
(47, 8),
(47, 17),
(48, 13),
(49, 11),
(49, 5),
(49, 2),
(50, 7),
(51, 13),
(51, 15),
(51, 6);


INSERT INTO LIB_FEES (CheckoutID, AccountID, FeeTypeID, Amount, PaidDate) VALUES
(1, 12, 4, 5, '2024-06-01'),
(1, 12, 2, 15, NULL),
(3, 30, 4, 17, '2024-09-14'),
(3, 30, 1, 20, '2024-09-14'),
(6, 34, 3, 12, NULL),
(6, 34, 2, 24, NULL),
(6, 34, 1, 25, NULL),
(8, 40, 3, 5, NULL),
(8, 40, 1, 12, NULL),
(10, 34, 1, 13, NULL),
(10, 34, 3, 13, NULL),
(12, 21, 4, 16, NULL),
(12, 21, 2, 18, NULL),
(13, 17, 1, 12, NULL),
(15, 38, 4, 9, NULL),
(17, 20, 1, 17, '2024-11-05'),
(21, 2, 4, 15, '2024-02-22'),
(21, 2, 3, 6, '2024-02-22'),
(25, 27, 3, 16, '2024-06-20'),
(29, 3, 1, 17, '2024-11-21'),
(29, 3, 3, 19, '2024-11-22'),
(31, 24, 3, 5, NULL),
(31, 24, 2, 14, '2024-08-06'),
(31, 24, 4, 10, NULL),
(32, 35, 3, 6, NULL),
(32, 35, 1, 13, '2024-03-30'),
(33, 20, 2, 6, NULL),
(34, 26, 3, 25, NULL),
(34, 26, 4, 14, NULL),
(34, 26, 1, 6, NULL),
(35, 29, 2, 11, '2024-08-09'),
(35, 29, 4, 16, NULL),
(35, 29, 1, 5, '2024-08-13'),
(36, 4, 2, 25, '2024-06-10'),
(36, 4, 1, 16, '2024-06-16'),
(36, 4, 4, 24, NULL),
(38, 19, 3, 22, '2024-05-01'),
(39, 40, 2, 20, NULL),
(40, 6, 4, 19, NULL),
(40, 6, 3, 7, '2024-06-11'),
(40, 6, 2, 13, '2024-06-18'),
(42, 37, 2, 5, NULL),
(42, 37, 4, 11, '2024-04-09'),
(42, 37, 1, 6, '2024-04-03'),
(43, 39, 1, 25, NULL),
(44, 30, 3, 18, NULL),
(47, 7, 4, 8, '2024-05-29'),
(47, 7, 2, 7, NULL),
(47, 7, 3, 15, '2024-05-26');