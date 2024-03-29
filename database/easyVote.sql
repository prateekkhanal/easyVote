CREATE DATABASE IF NOT EXISTS easyVote;
USE easyVote;

CREATE TABLE IF NOT EXISTS locations (
    lid int auto_increment primary key,
    location_name varchar(100)
);

CREATE TABLE IF NOT EXISTS roles (
    rid int auto_increment primary key,
    title varchar(100)
);

CREATE TABLE IF NOT EXISTS election_type (
    etid int auto_increment primary key,
    title varchar(100)
);

CREATE TABLE IF NOT EXISTS voters (
    vid int auto_increment primary key,
    name varchar(100),
    email varchar(120),
    password varchar(100),
    lid int ,
    FOREIGN KEY (lid) REFERENCES locations (lid),
    citizenship_number varchar(100),
    front_image varchar(100),
    back_image varchar(100),
    photo varchar(100),
	 authentic enum('pending', 'yes', 'no')
);

INSERT INTO `voters` (`vid`, `name`, `email`, `password`, `lid`, `citizenship_number`, `front_image`, `back_image`, `photo`, `authentic`) VALUES
(1, 'Pratik Khanal', 'khanalprateek101@gmail.com', '55a6f3e9bd61006125ba266065f28ecb', NULL, NULL, '1709521451_cs_front_1.jpg', '1709521451_cs_back_1.jpg', '1709521451_me.jpg', NULL),
(2, 'Santosh Mahato', 'santosh@mahato.com', '46de911433c0cd709639ae505f0ecc36', NULL, NULL, '1709521573_random_1_f.jpg', '1709521573_random_1_b.jpg', '1709521573_random_pp_1.jpg', NULL),
(3, 'Manish Kumar Shrestha', 'manish@shrestha.com', '46de911433c0cd709639ae505f0ecc36', NULL, NULL, '1709521640_random_2_f.jpg', '1709521640_random_2_b.jpg', '1709521640_random_pp_1.jpg', NULL);
(5, 'John Doe', 'john@doe.com', '46de911433c0cd709639ae505f0ecc36', NULL, NULL, '1709615442_random_1_f.jpg', '1709615442_random_1_b.jpg', '1709615442_random_pp_1.jpg', NULL);

CREATE TABLE IF NOT EXISTS election (
    eid int auto_increment primary key,
    title varchar(100),
    start_date date,
    end_date date,
    lid int ,
    FOREIGN KEY (lid) REFERENCES locations (lid),
    description TEXT(1000)
);

CREATE TABLE IF NOT EXISTS parties (
    pid int auto_increment primary key,
    name varchar(100),
    eid int,
    description TEXT(1000),
    logo varchar(100),
    FOREIGN KEY (eid) REFERENCES election(eid)
);

CREATE TABLE IF NOT EXISTS registered_voters (
    rvid int auto_increment primary key,
    vid int ,
    FOREIGN KEY (vid) REFERENCES voters (vid),
    eid int ,
    FOREIGN KEY (eid) REFERENCES election (eid)
);

CREATE TABLE IF NOT EXISTS candidate (
    cid int auto_increment primary key,
    vid int ,
    FOREIGN KEY (vid) REFERENCES voters (vid),
    eid int ,
    FOREIGN KEY (eid) REFERENCES election (eid),
    lid int ,
    FOREIGN KEY (lid) REFERENCES locations (lid),
    pid int,
    FOREIGN KEY (pid) REFERENCES parties(pid),
    description TEXT(1000)
);

CREATE TABLE IF NOT EXISTS votes (
    id int auto_increment primary key,
    eid int ,
    FOREIGN KEY (eid) REFERENCES election (eid),
    cid int ,
    FOREIGN KEY (cid) REFERENCES candidate (cid),
    vid int ,
    FOREIGN KEY (vid) REFERENCES voters (vid),
    time timestamp
);

CREATE TABLE IF NOT EXISTS pinned_elections (
    peid int auto_increment primary key,
    vid int ,
    FOREIGN KEY (vid) REFERENCES voters (vid),
    eid int ,
    FOREIGN KEY (eid) REFERENCES election (eid)
);

CREATE TABLE IF NOT EXISTS election_manager (
    emid int auto_increment primary key,
    vid int ,
    FOREIGN KEY (vid) REFERENCES voters (vid),
    eid int ,
    FOREIGN KEY (eid) REFERENCES election (eid),
    rid int ,
    FOREIGN KEY (rid) REFERENCES roles (rid)
);

CREATE TABLE IF NOT EXISTS faq (
	qid int auto_increment primary key,
	 question varchar(100),
	 answer varchar(100),
	 category varchar(100)
);

INSERT INTO faq (question, answer, category) VALUES ('What is online voting?', 'Online voting is a method of casting ballots using electronic devices connected to the internet. It allows eligible voters to securely submit their votes from any location with internet access, eliminating the need for physical polling stations.', 'General'),
('Is online voting secure?', 'Online voting systems employ various security measures such as encryption, authentication, and audit trails to ensure the integrity and confidentiality of votes. While no system is entirely risk-free, robust security protocols are implemented to mitigate potential threats.', 'Security'),
('How are voters authenticated in online voting?', 'Voters are typically authenticated through methods such as unique identifiers (e.g., voter ID numbers), passwords, biometric verification, or two-factor authentication. These measures help ensure that only eligible voters can cast their ballots.', 'Security'),
('What are the advantages of online voting?', 'Online voting offers several benefits, including increased accessibility for voters with disabilities, convenience for voters who may be unable to physically attend polling stations, cost savings for electoral authorities, and faster tabulation of results.', 'Benefits'),
('What are the challenges of implementing online voting?', 'Challenges associated with online voting include concerns about the security and integrity of the voting process, the potential for technical glitches or system failures, ensuring inclusivity for voters without internet access or digital literacy, and addressing privacy concerns related to electronic voting systems.', 'Challenges'),
('Can online voting be tampered with?', 'Online voting systems are designed with multiple layers of security to prevent tampering. However, like any technology, they are not immune to potential threats. Measures such as end-to-end encryption, robust authentication mechanisms, and rigorous auditing help mitigate the risk of tampering.', 'Security'),
('Are online voting systems vulnerable to hacking?', 'Online voting systems are subject to cybersecurity threats like any internet-connected technology. To mitigate the risk of hacking, voting systems employ encryption, firewalls, intrusion detection systems, and regular security updates. Additionally, independent security audits and rigorous testing are conducted to identify and address vulnerabilities.', 'Security'),
('How can voters verify that their votes are counted correctly in online voting?', 'Online voting systems often provide voters with a unique confirmation code or receipt after they cast their ballots. Additionally, some systems allow voters to verify their votes through online portals or by contacting election authorities. Transparency measures such as public auditing of voting software and cryptographic proofs may also enhance voter confidence in the accuracy of the electoral process.', 'Security'),
('What measures are in place to prevent voter coercion in online voting?', 'To prevent voter coercion, online voting systems may incorporate features such as secret ballots, which ensure that individual voting choices remain confidential. Additionally, measures such as voter authentication, audit trails, and penalties for coercion or voter fraud help safeguard the integrity of the voting process.', 'Security'),
('Can online voting accommodate voters with disabilities?', 'Yes, online voting can enhance accessibility for voters with disabilities by offering features such as screen readers, adaptive interfaces, and alternative input methods. Accessibility guidelines and standards are often integrated into the design of online voting systems to ensure inclusivity for all voters.', 'Accessibility'),
('What steps are taken to protect voter privacy in online voting?', 'Online voting systems employ encryption and anonymization techniques to protect the privacy of voter data. Personal information is typically stored securely and is only accessible to authorized personnel. Additionally, strict data protection regulations and privacy policies govern the handling of voter information.', 'Privacy'),
('Are there any age restrictions for online voting?', 'Age restrictions for online voting vary depending on the jurisdiction and the specific electoral regulations in place. In many cases, eligible voters must meet the minimum voting age requirement established by law to participate in online voting.', 'General'),
('What role do election officials play in online voting?', 'Election officials oversee the administration of online voting processes, including voter registration, ballot distribution, technical support, and results tabulation. They are responsible for ensuring the integrity, security, and fairness of the electoral process.', 'General'),
('How are disputes or irregularities addressed in online voting?', 'Disputes or irregularities in online voting may be addressed through mechanisms such as independent audits, recounts, investigations by electoral authorities, or legal challenges. Transparency, accountability, and adherence to established electoral procedures are essential for resolving issues and maintaining public trust in the integrity of the electoral process.', 'General'),
('Can online voting increase voter turnout?', 'Online voting has the potential to increase voter turnout by offering greater accessibility and convenience for voters. By eliminating barriers such as geographical constraints and long wait times at polling stations, online voting may encourage more people to participate in the electoral process.', 'General');
