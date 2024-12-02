-- Create the database
CREATE DATABASE LibraryDB;
USE LibraryDB;

-- Create the tables in proper order
CREATE TABLE LIB_ACCOUNT_TYPE (
    AccountTypeID TINYINT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(50) NOT NULL
);

CREATE TABLE LIB_ACCOUNT (
    AccountID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Phone VARCHAR(15) NOT NULL,
    Email VARCHAR(200) UNIQUE NOT NULL,
    Street VARCHAR(200) NOT NULL,
    City VARCHAR(100) NOT NULL,
    State CHAR(5) NOT NULL,
    Zip CHAR(5) NOT NULL,
    StartDate DATE NOT NULL,
    Username VARCHAR(50) UNIQUE NOT NULL,
    Password VARCHAR(200) NOT NULL,
    AccountTypeID TINYINT,
    FOREIGN KEY (AccountTypeID) REFERENCES LIB_ACCOUNT_TYPE(AccountTypeID) ON DELETE SET NULL
);

CREATE TABLE LIB_CLASS (
    ClassID TINYINT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(255) NOT NULL,
    Description TEXT NOT NULL,
    DurationMins TINYINT,
    ImagePath VARCHAR(255)
);

CREATE TABLE LIB_EVENT (
    EventID TINYINT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(255) NOT NULL,
    Description TEXT NOT NULL,
    ImagePath VARCHAR(255)
);

CREATE TABLE LIB_ROOM (
    RoomID TINYINT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Capacity TINYINT
);

CREATE TABLE LIB_CLASS_SCHEDULE (
    ScheduleSlotID INT AUTO_INCREMENT PRIMARY KEY,
    Date DATE NOT NULL,
    Time TIME NOT NULL,
    ClassID TINYINT,
    RoomID TINYINT,
    FOREIGN KEY (ClassID) REFERENCES LIB_CLASS(ClassID) ON DELETE SET NULL,
    FOREIGN KEY (RoomID) REFERENCES LIB_ROOM(RoomID) ON DELETE SET NULL
);

CREATE TABLE LIB_EVENT_SCHEDULE (
    ScheduleSlotID INT AUTO_INCREMENT PRIMARY KEY,
    Date DATE NOT NULL,
    Time TIME NOT NULL,
    EventID TINYINT,
    RoomID TINYINT,
    FOREIGN KEY (EventID) REFERENCES LIB_EVENT(EventID) ON DELETE SET NULL,
    FOREIGN KEY (RoomID) REFERENCES LIB_ROOM(RoomID) ON DELETE SET NULL
);

CREATE TABLE LIB_CLASS_REGISTRATION (
    RegistrationID INT AUTO_INCREMENT PRIMARY KEY,
    ScheduleSlotID INT,
    AccountID INT,
    FOREIGN KEY (ScheduleSlotID) REFERENCES LIB_CLASS_SCHEDULE(ScheduleSlotID) ON DELETE SET NULL,
    FOREIGN KEY (AccountID) REFERENCES LIB_ACCOUNT(AccountID) ON DELETE SET NULL
);

CREATE TABLE LIB_INSTRUCTOR (
    InstructorID TINYINT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Gender CHAR(1),
    Bio TEXT,
    ImagePath VARCHAR(255)
);

CREATE TABLE LIB_CLASS_INSTRUCTOR (
    ClassInstructorID TINYINT AUTO_INCREMENT PRIMARY KEY,
    ClassID TINYINT,
    InstructorID TINYINT,
    FOREIGN KEY (ClassID) REFERENCES LIB_CLASS(ClassID) ON DELETE SET NULL,
    FOREIGN KEY (InstructorID) REFERENCES LIB_INSTRUCTOR(InstructorID) ON DELETE SET NULL
);

CREATE TABLE LIB_CHECKOUT (
    CheckoutID BIGINT AUTO_INCREMENT PRIMARY KEY,
    AccountID INT,
    CheckoutDate DATE NOT NULL,
    DueDate DATE NOT NULL, -- Updated to NOT NULL
    ReturnDate DATE,
    FOREIGN KEY (AccountID) REFERENCES LIB_ACCOUNT(AccountID) ON DELETE SET NULL
);

CREATE TABLE LIB_FEE_TYPE (
    FeeTypeID TINYINT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL
);

CREATE TABLE LIB_FEES (
    FeesID BIGINT AUTO_INCREMENT PRIMARY KEY,
    CheckoutID BIGINT,
    AccountID INT,
    FeeTypeID TINYINT,
    Amount INT,
    PaidDate DATE,
    FOREIGN KEY (CheckoutID) REFERENCES LIB_CHECKOUT(CheckoutID) ON DELETE SET NULL,
    FOREIGN KEY (AccountID) REFERENCES LIB_ACCOUNT(AccountID) ON DELETE SET NULL,
    FOREIGN KEY (FeeTypeID) REFERENCES LIB_FEE_TYPE(FeeTypeID) ON DELETE SET NULL
);

CREATE TABLE LIB_ITEM_TYPE (
    ItemTypeID TINYINT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL
);

CREATE TABLE LIB_MEDIA_TYPE (
    MediaTypeID TINYINT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL
);

CREATE TABLE LIB_GENRE (
    GenreID TINYINT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL
);

CREATE TABLE LIB_PUBLISHER_TYPE (
    PublisherTypeID TINYINT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL
);

CREATE TABLE LIB_PUBLISHER (
    PublisherID TINYINT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    PublisherTypeID TINYINT, 
    FOREIGN KEY (PublisherTypeID) REFERENCES LIB_PUBLISHER_TYPE(PublisherTypeID) ON DELETE SET NULL
);

CREATE TABLE LIB_CREATOR_TYPE (
    CreatorTypeID TINYINT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL
);

CREATE TABLE LIB_CREATOR (
    CreatorID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Gender CHAR(1),
    DateBorn DATE,
    DateDied DATE,
    Bio TEXT,
    ImagePath VARCHAR(255),
    CreatorTypeID TINYINT,
    FOREIGN KEY (CreatorTypeID) REFERENCES LIB_CREATOR_TYPE(CreatorTypeID) ON DELETE SET NULL
);

CREATE TABLE LIB_ITEM (
    ItemID INT AUTO_INCREMENT PRIMARY KEY,
    Isbn VARCHAR(13) NOT NULL, 
    Title VARCHAR(255) NOT NULL,
    Description TEXT,
    Year SMALLINT,
    IssueNumber TINYINT,
    LibCopies TINYINT,
    ImagePath VARCHAR(255), 
    LibLocation VARCHAR(50), 
    ItemTypeID TINYINT,
    MediaTypeID TINYINT,
    GenreID TINYINT,
    FOREIGN KEY (ItemTypeID) REFERENCES LIB_ITEM_TYPE(ItemTypeID) ON DELETE SET NULL,
    FOREIGN KEY (MediaTypeID) REFERENCES LIB_MEDIA_TYPE(MediaTypeID) ON DELETE SET NULL,
    FOREIGN KEY (GenreID) REFERENCES LIB_GENRE(GenreID) ON DELETE SET NULL
);

CREATE TABLE LIB_ITEM_PUBLISHER (
    ItemPublisherID INT AUTO_INCREMENT PRIMARY KEY, 
    ItemID INT, 
    PublisherID TINYINT, 
    FOREIGN KEY (ItemID) REFERENCES LIB_ITEM(ItemID) ON DELETE SET NULL,
    FOREIGN KEY (PublisherID) REFERENCES LIB_PUBLISHER(PublisherID) ON DELETE SET NULL
);

CREATE TABLE LIB_ITEM_CREATOR (
    ItemCreatorID INT AUTO_INCREMENT PRIMARY KEY,
    ItemID INT,
    CreatorID INT,
    FOREIGN KEY (ItemID) REFERENCES LIB_ITEM(ItemID) ON DELETE SET NULL,
    FOREIGN KEY (CreatorID) REFERENCES LIB_CREATOR(CreatorID) ON DELETE SET NULL
);

CREATE TABLE LIB_CHECKOUT_ITEM (
    CheckoutItemID BIGINT AUTO_INCREMENT PRIMARY KEY,
    CheckoutID BIGINT,
    ItemID INT,
    FOREIGN KEY (CheckoutID) REFERENCES LIB_CHECKOUT(CheckoutID) ON DELETE SET NULL,
    FOREIGN KEY (ItemID) REFERENCES LIB_ITEM(ItemID) ON DELETE SET NULL
);