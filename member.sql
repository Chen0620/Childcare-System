CREATE TABLE Organization
(
	OrganizationID INT NOT NULL AUTO_INCREMENT,
	OrganizationName VARCHAR(45),
	OrganizationAddress VARCHAR(45),
	MemberID INT,
	PRIMARY KEY (OrganizationID),
	CONSTRAINT FK_Org FOREIGN KEY (MemberID) REFERENCES Member
);

CREATE TABLE Member
(	MemberID INT NOT NULL AUTO_INCREMENT,
	MemberFname VARCHAR(45) NOT NULL,
	MemberLname VARCHAR(45) NOT NULL,
	MemberPhone VARCHAR(10),
	MemberBday VARCHAR(45) NOT NULL,
	MemberAddress VARCHAR(45),
	MemberDate VARCHAR(45),
	Memberspouse VARCHAR(45),
	OrganizationName VARCHAR(45),
	PRIMARY KEY (MemberID),
	
	CONSTRAINT FK_Member FOREIGN KEY (OrganizationName) REFERENCES Organization
);

CREATE TABLE VolunteerOpportunities
(
	VolOpprtID INT NOT NULL AUTO_INCREMENT,
	VolOpprtDate DATE,
	VolOpprtNumNeed INT,
	VolOpprtDescription VARCHAR(200),
	MemberID INT,
	PRIMARY KEY (VolOpprtID),
	CONSTRAINT FK_VolunteerOpportunities FOREIGN KEY (MemberID) REFERENCES Member
);

CREATE TABLE ChildinChildCare
(
	ChildID INT NOT NULL AUTO_INCREMENT,
	ChildName VARCHAR(45),
	ChildBDay DATE,
	PRIMARY KEY (ChildID)
);

--TeacherinChildcare ChildinChildcare ChildcareFamily Payment
CREATE TABLE TeacherinChildcare
(
	TeacherID INT NOT NULL AUTO_INCREMENT,
	TeacherNAME VARCHAR(45),
	TeacherRoom VARCHAR(10),
	PRIMARY KEY (TeacherID)
);

CREATE TABLE ChildinChildcare
(
	ChildCID INT NOT NULL AUTO_INCREMENT,
	ChildCName VARCHAR(45),
	ChildCBDay DATE,
	PRIMARY KEY (ChildCID)
);


CREATE TABLE ChildcareFamily
(
	FamilyID INT NOT NULL AUTO_INCREMENT,
	FamilyName VARCHAR(45),
	FamilyPaymentAmt INT,
	FamilyAddress VARCHAR(200),
	FamilyPhone VARCHAR(20),
	Spouse VARCHAR(45),
	PRIMARY KEY (FamilyID)
);

CREATE TABLE Payment
(
	PaymentID INT NOT NULL AUTO_INCREMENT,
	PayAmt INT,
	PayCheckNO VARCHAR(10),
	PayChildcareNO VARCHAR(10),
	PayDescription VARCHAR(200),
	PRIMARY KEY (PaymentID)	
);
