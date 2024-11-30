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
('Pacific', 60);

INSERT INTO LIB_CREATOR (Name, Gender, DateBorn, DateDied, Bio, ImagePath, CreatorTypeID) VALUES
('Mark Twain', 'M', '1835-11-30', '1910-04-21', 'Famous for works like Adventures of Huckleberry Finn and The Adventures of Tom Sawyer.', 'ImageDirectory/creator-img-1.webp', 1),
('J.K. Rowling', 'F', '1965-07-31', NULL, 'Best known for writing the Harry Potter series.', 'ImageDirectory/creator-img-2.png', 1),
('George Orwell', 'M', '1903-06-25', '1950-01-21', 'Famous for works such as 1984 and Animal Farm.', 'ImageDirectory/creator-img-3.jpg', 1),
('Maya Angelou', 'F', '1928-04-04', '2014-05-28', 'Known for her autobiographies and poetry, including I Know Why the Caged Bird Sings.', 'ImageDirectory/creator-img-4.jpg', 1),
('William Shakespeare', 'M', '1564-04-23', '1616-04-23', 'The iconic playwright, known for works like Romeo and Juliet, Macbeth, and Hamlet.', 'ImageDirectory/creator-img-5.jpg', 1), 
('Harper Lee', 'F', '1926-04-28', '2016-02-19', 'An American novelist whose 1960 novel To Kill a Mockingbird won the 1961 Pulitzer Prize and became a classic of modern American literature.', 'ImageDirectory/creator-img-6.webp', 1),
('Barbara A. Mowat', 'F', '1934-01-29', '2017-11-24', ' Director of Research emerita at the Folger Shakespeare Library, Consulting Editor of Shakespeare Quarterly, and author of The Dramaturgy of Shakespeare\'s Romances and of essays on Shakespeare\'s plays and their editing.', 'ImageDirectory/creator-img-7.jpg', 9),
('Paul Werstine', 'M', NULL, NULL, 'Professor Werstine has spent his career teaching Shakespeare and Medieval and Renaissance English Literature at King\'s University College.', 'ImageDirectory/creator-img-8.jpg', 9), 
('J.R.R. Tolkien', 'M', '1872-01-03', '1973-09-02', 'J.R.R. Tolkien was a British author, philologist, and academic, best known for creating the legendary fantasy works The Hobbit and The Lord of the Rings trilogy. Born in 1892 in Bloemfontein, South Africa, he grew up in England and developed a deep love for languages, which heavily influenced his world-building and storytelling. His richly imagined Middle-earth, complete with its own histories, cultures, and languages, has inspired generations of readers and shaped modern fantasy literature. A professor at Oxford University, Tolkien was also a scholar of Old English and medieval literature. His work remains a cornerstone of fantasy fiction, celebrated for its depth, moral complexity, and enduring themes of friendship and courage.', 'ImageDirectory/creator-img-JRR-Tolkien.webp', 1);

INSERT INTO LIB_PUBLISHER (Name, PublisherTypeID) VALUES
('Charles L. Webster & Co.', 1),
('Bloomsbury Publishing', 1),
('Secker & Warburg', 1),
('Random House', 1),
('Ballantine Books', 1), 
('Folger Shakespeare Library', 1), 
('William Morrow Paperbacks', 1);


INSERT INTO LIB_ITEM (Isbn, Title, Description, Year, IssueNumber, LibCopies, ImagePath, LibLocation, ItemTypeID, MediaTypeID, GenreID) VALUES
('9783161484100','Adventures of Huckleberry Finn', 'A novel by Mark Twain that chronicles the adventures of a young boy and an escaped slave.', 1884, 1, 2, 'ImageDirectory/item-img-1.webp', 'FIC TWA 813.4', 1, 1, 21),
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
('9780547928203','The Two Towers: The Lord of the Rings', 'The journey of Frodo and Sam continue as they venture toward Mordor to destroy the One Ring, guided by the treacherous creature Gollum. Meanwhile, Aragorn, Legolas, and Gimli pursue their kidnapped friends, Merry and Pippin, leading to battles against the forces of Saruman and the defense of Rohan at Helm\'s Deep.', 1954, 1, 3, 'ImageDirectory/item-img-two-towers.jpg', 'FIC 814.80 JR', 1, 1, 1);

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
(12, 9) -- "The Two Towers" by J.R.R. Tolkien
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
(12, 7) -- "The Two Towers" by J.R.R. Tolkien
;

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
('Jack', 'White', '801-012-3456', 'jack.white@example.com', '707 Legend Ln.', 'Salt Lake City', 'UT', '84110', '2024-01-10', 'jwhite', '$2y$10$AxuyLeavLr5zx37Xdhls2.42eHxTaaUqlD5rU/LKWp5fo6/ODa3DG', 3);


INSERT INTO LIB_CHECKOUT (AccountID, CheckoutDate, DueDate, ReturnDate) VALUES 
(1, '2024-11-15', '2024-11-29', '2024-11-25'),
(3, '2024-11-12', '2024-11-26', '2024-11-18'),
(3, '2024-11-17', '2024-12-01', NULL),
(3, '2024-11-25', '2024-12-09', '2024-12-05'),
(4, '2024-11-05', '2024-11-19', NULL),
(5, '2024-11-01', '2024-11-15', '2024-11-10'),
(6, '2024-11-20', '2024-12-04', '2024-11-30'),
(6, '2024-11-25', '2024-12-09', NULL),
(7, '2024-11-18', '2024-12-02', NULL),
(8, '2024-11-22', '2024-12-06', NULL),
(8, '2024-11-15', '2024-11-29', '2024-11-28'),
(9, '2024-11-10', '2024-11-24', NULL),
(9, '2024-11-25', '2024-12-09', '2024-12-01');


INSERT INTO LIB_CHECKOUT_ITEM (CheckoutID, ItemID) VALUES
(1, 3),
(2, 1),
(3, 2),
(3, 5),
(3, 7),
(4, 4),
(5, 6),
(6, 8),
(6, 11),
(7, 9),
(8, 10),
(8, 12),
(8, 3),
(9, 4),
(9, 2),
(10, 5),
(10, 1),
(10, 7),
(11, 6),
(11, 9),
(12, 8),
(12, 10),
(13, 11),
(13, 12);

INSERT INTO LIB_FEES (CheckoutID, AccountID, FeeTypeID, Amount, PaidDate) VALUES 
-- Account 1: One returned item, returned before due date
(1, 1, 2, 10, '2024-11-27'), -- Damage fee for returned item

-- Account 3: Multiple checkouts
(2, 3, 1, 5, '2024-11-20'), -- Late fee for item returned after due date
(2, 3, 4, 8, '2024-11-20'), -- Cleaning fee for returned item
(3, 3, 3, 50, NULL),        -- Lost item fee for unreturned item
(4, 3, 2, 15, '2024-12-10'), -- Damage fee for returned item


-- Account 4: One checkout, no fees
-- No fees for Account 4's CheckoutID 5

-- Account 5: One returned item, returned before due date
(6, 5, 4, 10, '2024-11-12'), -- Cleaning fee for returned item

-- Account 6: Two checkouts
(7, 6, 1, 5, '2024-12-01'), -- Late fee for item returned after due date
(7, 6, 4, 10, '2024-12-01'), -- Cleaning fee for returned item
(8, 6, 3, 50, NULL),        -- Lost item fee for unreturned item

-- Account 7: One checkout, no return date
(9, 7, 3, 40, NULL),        -- Lost item fee for unreturned item

-- Account 8: Two checkouts
(10, 8, 1, 10, '2024-12-07'), -- Late fee for item returned after due date
(10, 8, 4, 5, '2024-12-07'),  -- Cleaning fee for returned item
(11, 8, 3, 60, NULL),         -- Lost item fee for unreturned item

-- Account 9: Two checkouts
(12, 9, 3, 40, NULL),         -- Lost item fee for unreturned item
(13, 9, 4, 20, '2024-12-02'); -- Cleaning fee for returned item