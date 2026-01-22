<?php
include 'includes/sessioning.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>DAMS</title>
        <?php include 'parts/links.php' ?>
        <style>
            /* General Modal Styling */
.modal-content {
    background: #fdfdfd;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    font-family: 'Georgia', serif;
    line-height: 1.6;
    color: #333;
}

/* Modal Header */
.modal-header {
    color: white;
    padding: 15px;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    text-align: center;
}

.modal-title {
    font-size: 22px;
    font-weight: bold;
    text-transform: uppercase;
}

/* Modal Body (Content Section) */
.modal-body {
    max-height: 500px;
    overflow-y: auto;
    padding: 20px;
}

/* Justified Text */
.modal-body p {
    font-size: 16px;
    text-align: justify;
    margin-bottom: 15px;
}

/* Category Headings */
.modal-body h5 {
    font-size: 18px;
    font-weight: bold;
    color: #004085;
    text-transform: uppercase;
    border-bottom: 2px solid #004085;
    padding-bottom: 5px;
    margin-top: 20px;
}

.modal-body h6 {
    font-size: 17px;
    font-weight: bold;
    color: #bd5d38;
    margin-top: 15px;
}

/* Offense Categories */
.category-a {
    background: #f8f9fa;
    border-left: 5px solid #28a745;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    text-align: justify;
}

.category-b {
    background: #fff3cd;
    border-left: 5px solid #ffc107;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    text-align: justify;
}

.category-c {
    background: #f8d7da;
    border-left: 5px solid #dc3545;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    text-align: justify;
}

/* List Styling */
ul {
    padding-left: 20px;
}

ul li {
    margin-bottom: 5px;
    text-align: justify;
}

/* Footer */
.modal-footer {
    background: #f1f1f1;
    padding: 10px;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    text-align: right;
}

.btn-secondary {
    background: #6c757d;
    border: none;
}

/* Scrollbar Customization */
.modal-body::-webkit-scrollbar {
    width: 6px;
}

.modal-body::-webkit-scrollbar-thumb {
    background-color: #888;
    border-radius: 3px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Remove hover effect */
.da-card:hover {
    box-shadow: none; /* Remove box-shadow on hover */
    transform: none;  /* Remove any transform effect */
}

.da-card-photo a:hover {
    text-decoration: none; /* Remove underline on hover, if any */
}


        </style>
	</head>
	</head>
	<body>
    <?php include 'parts/header.php'?>
	<div class="mobile-menu-overlay"></div>

		<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="gallery-wrap">
						<ul class="row">
					<!-- Modal Trigger (Image as Trigger) -->
                        <li class="col-lg-4 col-md-6 col-sm-12">
                            <div class="da-card box-shadow">
                                <div>
                                    <a href="#handbookModal" data-toggle="modal" class="open-modal">
                                        <img assets/src="assets/vendors/images/section1.jpg" alt="" />
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="col-lg-4 col-md-6 col-sm-12">
                            <div class="da-card box-shadow">
                                <div>
                                    <a href="#studentGuidelinesModal" data-toggle="modal" class="open-modal">
                                        <img assets/src="assets/vendors/images/section2.jpg" alt="" />
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="col-lg-4 col-md-6 col-sm-12">
                            <div class="da-card box-shadow">
                                <div>
                                    <a href="#section3Modal" data-toggle="modal" class="open-modal">
                                        <img assets/src="assets/vendors/images/section3.jpg" alt="" />
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="col-lg-4 col-md-6 col-sm-12">
                            <div class="da-card box-shadow">
                                <div>
                                    <a href="#section4Modal" data-toggle="modal" class="open-modal">
                                        <img assets/src="assets/vendors/images/section4.jpg" alt="" />
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="col-lg-4 col-md-6 col-sm-12">
                            <div class="da-card box-shadow">
                                <div>
                                    <a href="#section5Modal" data-toggle="modal" class="open-modal">
                                        <img assets/src="assets/vendors/images/section5.jpg" alt="" />
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="col-lg-4 col-md-6 col-sm-12">
                            <div class="da-card box-shadow">
                                <div>
                                    <a href="#section6Modal" data-toggle="modal" class="open-modal">
                                        <img assets/src="assets/vendors/images/section6.jpg" alt="" />
                                    </a>
                                </div>
                            </div>
                        </li>
							
                       

						</ul>
					</div>
				</div>
			</div>
		</div>
		
		


<!-- modals -->


<!-- Modal Structure 1 -->
<div class="modal fade" id="handbookModal" tabindex="-1" role="dialog" aria-labelledby="handbookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="handbookModalLabel">SECTION 1: CLASSIFICATION OF OFFENSES</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Students must bear in mind that disciplinary measures are formulated to help attain self-discipline, 
                    preserve peace and order, and become responsible persons with Christian ideals and values.
                </p>

                <h5 class="mb-10">1. Offenses</h5>

                <h6><strong>Category A - Reprimand</strong></h6>
                <ul>
                    <li>•Loitering and creating noise or any disturbance in the corridors, stairways when classes are going on.</li>
                    <li>•Failure to wear the proper school attire.</li>
                    <li>•Shouting, whistling, and unrestrained laughter and loud talking inside the classroom.</li>
                    <li>•Unauthorized use of school facilities.</li>
                    <li>•Tampering with notices on bulletin boards.</li>
                    <li>•Non-payment of school debts (program/club).</li>
                    <li>•Wearing of uniform in parks, video game houses, billiard halls, disco places, etc.</li>
                </ul>
                <p>A student may be meted with suspension after three warnings are served for various offenses during his stay in the College Department.</p>

                <h6><strong>Category B - Suspension</strong></h6>
                <p>Offenses punishable by suspension:</p>
                <ul>
                    <li>•Cheating during tests or examinations.</li>
                    <li>•Smoking inside the school premises.</li>
                    <li>•Committing acts of vandalism.</li>
                    <li>•Gambling of any sort.</li>
                    <li>•Drunkenness and possession of liquor.</li>
                    <li>•Refusal to wear the school-issued I.D. and the prescribed school uniform while inside the campus.</li>
                    <li>•Use of fake and borrowed examination permits and school I.D.</li>
                    <li>•Discourtesy to a teacher, school official, or employee of the institution.</li>
                    <li>•Possessing pornographic materials within the school premises.</li>
                    <li>•Causing public and campus disturbances.</li>
                    <li>•Refusing without valid reason to appear before a school official.</li>
                    <li>•Initiating a fundraising activity or using the name of the school without approval.</li>
                    <li>•Publishing or circulating false information about the school or its faculty.</li>
                    <li>•Unauthorized use of the school's name in any public statement.</li>
                    <li>•Wearing earrings for male students or more than one pair for female students.</li>
                    <li>•Highly colored hair.</li>
                    <li>•Desecration of religious images, disrespect to religious practices and national symbols.</li>
                    <li>•Malicious activation of fire alarms.</li>
                    <li>•Maligning the Catholic Church, its teachings, or practices.</li>
                    <li>•Failure to comply with summons or notices for disciplinary investigation.</li>
                    <li>•Exhibiting nudity or explicit content on social media.</li>
                    <li>•Cyberbullying.</li>
                    <li>•Participating in beauty contests wearing inappropriate attire.</li>
                    <li>•Other acts analogous to the above.</li>
                </ul>

                <h6><strong>Category C - Expulsion</strong></h6>
                <p>Offenses punishable by expulsion:</p>
                <ul>
                    <li>•Assaulting a teacher or any school authority.</li>
                    <li>•Carrying and concealing deadly weapons.</li>
                    <li>•Extortion or asking for money from others.</li>
                    <li>•Fighting and causing injury to others.</li>
                    <li>•Using, possessing, or selling prohibited drugs.</li>
                    <li>•Engaging in immoral acts such as premarital sexual relations resulting in pregnancy.</li>
                    <li>•Instigating, leading, or participating in activities leading to class stoppage.</li>
                    <li>•Threatening school authorities or faculty.</li>
                    <li>•Forging or tampering with school records.</li>
                    <li>•Hazing or recruiting for organizations involved in hazing.</li>
                    <li>•Drug addiction.</li>
                    <li>•Participating in strikes and demonstrations causing school disruptions.</li>
                    <li>•Stealing school property.</li>
                    <li>•Misuse of school documents.</li>
                    <li>•Destruction or damage of school property.</li>
                    <li>•Libel or defamation against faculty or students.</li>
                    <li>•Possession or distribution of subversive materials.</li>
                    <li>•Conviction for a criminal offense.</li>
                    <li>•Any other crime or misdemeanor deemed serious by the Student Disciplinary Board.</li>
                </ul>

                <p>
                    St. Mary's College of Bansalan is a Catholic school under the Religious of the Virgin Mary (RVM) Congregation. 
                    Its goal is to provide education aligned with Catholic beliefs, traditions, and values. 
                    Its policies promote Catholic moral teachings as protected by the 1987 Philippine Constitution.
                </p>

                <p>
                    Immorality refers to acts contrary to Catholic teachings as discussed in the Catechism of the Catholic Church.
                    These include but are not limited to fornication, pornography, prostitution, premarital sex, homosexuality, 
                    adultery, and other acts contrary to Catholic values.
                </p>

                <p>
                    <strong>Provisions for Students Engaging in Premarital Relations:</strong>
                </p>
                <ul>
                    <li>If the case is discovered within the semester, the student may complete the semester but cannot enroll in the next unless a marriage certificate or Solo Parent ID is presented.</li>
                    <li>Unwed mothers who choose not to marry must secure a Solo Parent ID from the DSWD.</li>
                    <li>Unwed fathers must provide proof they are not cohabiting with someone.</li>
                    <li>Graduating students may still graduate but are prohibited from attending graduation ceremonies.</li>
                </ul>

                <p>
                    These measures are not considered discriminatory but are consequences of the acts committed.
                </p>

                <h5 class="mb-10">2. Sanctions</h5>
											<p>
											<strong>a. Major Offense</strong><br>
											<strong>Exclusion</strong> This is the dropping of a student from the school rolls in a semester, two semesters or both, or for the whole school year. Transfer credentials are immediately issued. Excluding a student for two times may lead to his/her expulsion.<br>
												</p>

												<p>
												<strong>b. Minor Offense</strong><br>
												<strong>1. Reprimand</strong> This is a written warning to the erring student that a commission of a similar offense in the future shall be dealt with severely.<br>
												<br>
												<strong>2. Suspension</strong> This is the deprivation of an erring student to attend classes for a period of not exceeding 20% of the prescribed school days for a semester.<br>
												a.<strong> First Offense:</strong> Submission of letter of apology and short interview/ counseling session.<br>
												b.<strong> Second Offense:</strong> Suspension for one to two days and counseling session at least twice.<br>
												c.<strong>Third Offense:</strong> Suspension for two to four days, counseling session at least five times and community service may be given in the following forms of work.<br>
												• Cleaning the school grounds, offices, CRS, canteen<br>
												• Painting the walls of CRs, classroms or offices<br>
												• Assisting the librarian, Prefect of Discipline, Guidance Counselor in some routinary work<br>
												• Making research on reaction papers<br>
												• Fixing chairs or doing simple carpentry works<br>
                                                • Gardening
												• Digging a hole/canal in the campus<br>
												<strong>Note:</strong><br>
												The student will be disqualified from holding or seeking any position on any school organizations.<br>
												If a student is suspended for the fourth time of the same offense, his/her violation will lead to exclusion.<br>
												<br>
												<strong>3. Determining the violation</strong><br>
												a. The faculty members have the right to evaluate and censure their students for any minor violations.<br>
												b. With regard to academic matters, the Dean of College in coordination with the Program Head assumes the responsibility of determining the nature of the offense committed by the student.<br>
												c. The Student Disciplinary Board, upon the recommendation of the Prefect of Discipline, shall have the duty to hear and decide the cases. The decision of the Board may be appealed to the Office of the School President.<br>
												d. The evaluation of the violation will be based on the mitigating and aggravating circumstances and evidences to be determined by the Prefect of Discipline.<br>
												<br>
												<strong>4. Jurisdiction of the Cases</strong><br>
												a. Academic problems: Office of the Dean of College.<br>
												b. Faculty problems: Office of the Dean of College.<br>
												C. Non-academic and other problems of students: Office of the Prefect of Discipline.<br>
												<br>
												<strong>5. Student Disciplinary Board</strong><br>
												a. Functions and duties<br>
												1. Investigates cases referred by the Prefect of Discipline and within its jurisdiction<br>
												2. Recommends sanctions for the accused to the President of the school<br>
												3. Submits policy recommendations (crafting, innovation, improvement) to the School President pertaining to student discipline and decorum of the school.<br>
												<br>
												b. Composition<br>
												1. Prefect of Discipline as Chairperson<br>
												2. Dean of College as (Vice-Chairperson)<br>
												3. Christian Formation Coordinator<br>
												4. Representative from the faculty<br>
												5. Representative from the Non-teaching staff<br>
												6. Guidance Counselor<br>
												7. Student Executive Board President or his/her representative<br>
												<br>
												<strong>6. Procedural Due Process</strong><br>
												a. The student must be informed in writing of the nature and cause of the accusations against him/her.<br>
												b. The student must be informed of his/her right to answer the charges against him/her, with the assistance of the counsel, if desired.<br>
												c. The student must be told of the evidence against him/her.<br> 
												d. The student must be told of his/her right to present evidence on his/her behalf.<br>
												e. Evidences must be considered by the student disciplinary board.<br>
												f. Upon completion of the investigation, the student must be informed about the findings and recommendations of the members of the board. He/she must also be informed of his/her right to make an appeal about the decision to be submitted to the School President. If a student is minor, his/her parents are required to attend during the hearing and other meetings. If the student is of legal age, his/her parents can participate in the hearing and investigation upon request and with the approval of the student.<br>
												</p>
            </div>
            <div class="modal-footer">
              
            </div>
        </div>
    </div>
</div>
<!-- Modal Structure 2 -->
<div class="modal fade" id="studentGuidelinesModal" tabindex="-1" role="dialog" aria-labelledby="studentGuidelinesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentGuidelinesModalLabel">Guidelines for Students and Visitors</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="mb-3">A. Guidelines for Students</h5>
                <ul>
                    <li><b>1.</b>All students are required to wear complete school uniforms and wear their IDs at all times while in school. Students with incomplete uniforms (no ID, colored shirts, and sandals) are not allowed to enter the school campus.</li>
                    <li><b>2.</b>School bags and other personal belongings are the responsibilities of the students and not the security guard. The guards are not allowed to keep for safety things of the students and personnel in the guard house. However, security guards are authorized to inspect school bags and other belongings if necessary.</li>
                    <li><b>3.</b>The security guard may not allow entrance, at any time, any person with no proper identification and/or official business appointment with any school official, faculty, or student.</li>
                </ul>

                <h5 class="mb-3">B. Guidelines for Visitors</h5>
                <ul>
                    <li><b>1.</b>Visitors shall sign the visitor's logbook and wear the visitor's ID.</li>
                    <li><b>2.</b>Boxes/Packages are subject to inspections and shall be submitted when requested by the guards.</li>
                    <li><b>3.</b>Visitors can transact business only in office or with the person indicated in the Visitor's ID. They are not allowed to enter the classrooms or loiter along the corridors.</li>
                </ul>
            </div>
            <div class="modal-footer">
              
            </div>
        </div>
    </div>
</div>

<!-- Modal for Section 3: Rules and Regulations -->
<div class="modal fade" id="section3Modal" tabindex="-1" aria-labelledby="section3ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="section3ModalLabel">Section 3: Rules and Regulations - Reference: (EMC, 2013)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>A. INTRODUCTION</h6>
        <p>ST. MARY'S COLLEGE OF BANSALAN, INC. is committed to providing a caring, friendly, safe, and healthy learning environment. Accordingly, the School has a zero-tolerance policy for bullying that infringes on the safety and health of any student.</p>
        <p>All members of the School community collaboratively work together to make the School a happy and secure place. The School supports the Convention on the Rights of the Child (CRC) and follows Republic Act No. 10627 (Anti-Bullying Act of 2013) through its Child Protection Committee.</p>
        
        <h6>B. FORMS OF BULLYING</h6>
        <p>Bullying includes but is not limited to:</p>
        <ul>
          <li>•Physical aggression such as punching, pushing, or using objects as weapons.</li>
          <li>•Psychological harm, including name-calling and slanderous statements.</li>
          <li>•Cyberbullying through electronic means.</li>
        </ul>
        
        <h6>C. OBJECTIVES OF THE POLICY</h6>
        <ul>
          <li>•Increase awareness of bullying effects.</li>
          <li>•Improve student discipline.</li>
          <li>•Enhance teacher's classroom management.</li>
          <li>•Boost parental involvement in school activities.</li>
        </ul>
        
        <h6>D. FOCUS OF THE POLICY</h6>
        <p>Professional development and training for all stakeholders in:</p>
        <ul>
          <li>•Student leadership and service learning.</li>
          <li>•Faculty training for homeroom programs.</li>
          <li>•Family enrichment programs.</li>
          <li>•Anti-bullying week advocacies.</li>
        </ul>
        
        <h6>E. THE YOUTH PROTECTION COMMITTEE</h6>
        <p>The committee promotes a zero-tolerance policy and consists of:</p>
        <ul>
          <li>•Dean of College</li>
          <li>•Program Heads/Coordinators</li>
          <li>•Guidance Counselor</li>
          <li>•Coordinator of Student Affairs and Discipline</li>
        </ul>
        
        <h6>F. FUNCTIONS OF THE COMMITTEE</h6>
        <ul>
          <li>•Draft and review child protection policies.</li>
          <li>•Organize anti-bullying activities.</li>
          <li>•Establish referral and monitoring systems.</li>
          <li>•Coordinate with authorities on child protection.</li>
        </ul>
        
        <h6>G. PROCEDURES FOR DISCIPLINARY ACTION</h6>
        <ul>
          <li>•Incident reporting and investigation.</li>
          <li>•Informing parents/guardians of involved parties.</li>
          <li>•Disciplinary measures in compliance with due process.</li>
          <li>•Implementation of intervention programs.</li>
        </ul>
        
        <h6>H. BULLYING INCIDENT HANDLING PROCEDURES</h6>
        <ol>
          <li>•Incident Register - Staff records details of the incident.</li>
          <li>•Reports - Witnesses complete a standardized form.</li>
          <li>•Follow-up - Counseling and monitoring of affected students.</li>
          <li>•Warning - Written notice to repeat offenders.</li>
          <li>•Parent Intervention - Meeting with parents for serious cases.</li>
          <li>•Final Measures - Disciplinary actions recorded by the Prefect of Discipline.</li>
        </ol>
      </div>
      <div class="modal-footer">
      
      </div>
    </div>
  </div>
</div>

<!-- Modal for Section 4: Rules and Regulations -->
<div class="modal fade" id="section4Modal" tabindex="-1" aria-labelledby="section4Modal" aria-hidden="true">
  <div class="modal-dialog modal-lg d-flex justify-content-center">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="section4Modal">Rule 2 <br>Punishable Acts and Penalties Cybercrimes <br></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Section 4. Cybercrime Offenses.</h6>
        <p>The following acts constitute the offense of core cybercrime punishable under the Act.</p>
        <p>A. Offenses against the confidentiality, integrity and availability of computer data and systems shall be punished with imprisonment of prison mayor or a fine of at least Two Hundred Thousand Pesos (P200,000.00) up to a maximum amount commensurate to the damage incurred, or both, except with respect to number 5 herein:
       <br> 1. Illegal Access <br>
        2. Illegal Interception
       <br> 3. Data Interference <br>
       4. System Interference 
    </p>
        
        <p>B. Computer-related Offenses, which shall be punished with imprisonment of prison mayor, or a fine of at least Two Hundred Thousand Pesos (P200,000.00) up to a maximum amount commensurate to the damage incurred, or both, are as follows:</p>
        <p>Bullying includes but is not limited to:</p>
        <br> 1. Computer-related Forgery <br>
        2. Computer-related Fraud
       <br> 3.Computer-related Identity Theft <br>
       
    <p> C. Content-related Offenses:
    Any person found guilty of Child Pornography shall be punished in accordance with the penalties set forth in Republic Act No. 9775 or the "Anti-Child Pornography 
    Act of 2009" Provided. That the penalty to be imposed shall be one (1) degree higher than that provided for in Republic Act No. 9775 if committed through a
    computer system. </p>
       
      </div>
      <div class="modal-footer">
      
      </div>
    </div>
  </div>
</div>

<!-- Modal Structure 5 -->
<div class="modal fade" id="section5Modal" tabindex="-1" role="dialog" aria-labelledby="section5Modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="section5Modal">Section 5. <strong> DATA PRIVACY ACT OF 2012 (RA No. 10173) </strong>  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p> 1. Informational privacy refers to privacy interest in precluding the dissemination or misuse of sensitive and confidential information. Personal information is defined as "any information from which the identity of an individual is apparent or
                     can be directly ascertained by the entity holding the information." The DPA further recognizes a special category of personal information entitled to heightened degree of protection (and correspondingly, steeper sanctions), namely, "Sensitive Personal Information" which includes, among others things, information about person's marital status, age, color,
                      religious affiliation, health and education, as well as "any proceeding for any offense committed or alleged to have been committed by such person, or the sentence       </p>
                      <p> 2. A school is personal information controller under the DPA as it of any court in such proceedings."
                      processes personal information by collecting, organizing, recording, entering, storing, using, accessing, or sharing, such personal information in their computer systems. The DPA imposes severe penal sanctions on any person or entity that violates its provisions either knowingly or through negligence. The DPA defines and penalizes various types of conduct in regard to personal information such as:      </p>
                <ul>
                    <li><b>1.</b>All students are required to wear complete school uniforms and wear their IDs at all times while in school. Students with incomplete uniforms (no ID, colored shirts, and sandals) are not allowed to enter the school campus.</li>
                    <li><b>2.</b>School bags and other personal belongings are the responsibilities of the students and not the security guard. The guards are not allowed to keep for safety things of the students and personnel in the guard house. However, security guards are authorized to inspect school bags and other belongings if necessary.</li>
                    <li><b>3.</b>The security guard may not allow entrance, at any time, any person with no proper identification and/or official business appointment with any school official, faculty, or student of any court in such proceedings.</li>
                </ul>

                <h5 class="mb-3">B. Guidelines for Visitors</h5>
                <ul>
                    <li><b>1.</b>Visitors shall sign the visitor's logbook and wear the visitor's ID.</li>
                    <li><b>2.</b>Boxes/Packages are subject to inspections and shall be submitted when requested by the guards.</li>
                    <li><b>3.</b>Visitors can transact business only in office or with the person indicated in the Visitor's ID. They are not allowed to enter the classrooms or loiter along the corridors.</li>
                </ul>
            </div>
            <div class="modal-footer">
              
            </div>
        </div>
    </div>
</div>

<!-- Modal Structure 6 -->
<div class="modal fade" id="section6Modal" tabindex="-1" role="dialog" aria-labelledby="section6Modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="section6Modal">SMCBI SEXUAL HARASSMENT POLICIES & PROCEDURES</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <ul>
                    <li><b>•</b>Pursuant to the provisions of Section 4, Republic Act 7877, An Act Declaring Sexual Harassment Unlawful in the Employment, Education or 
                    Training Environment, and For Other Purposes, the following policies and procedures are hereby issued by St. Mary's College of Bansalan to prevent sexual harassment and to guarantee full respect for human rights and uphold the dignity of employees, 
                    applicant for employment, students or those undergoing training, instruction or education, and to provide the procedure for the resolution, settlement and/or disposition of sexual harassment cases. Towards this end, all forms of sexual harassment in the employment, education or training environment are hereby declared unlawful. </li>
                    <li><b>2.</b>School bags and other personal belongings are the responsibilities of the students and not the security guard. The guards are not allowed to keep for safety things of the students and personnel in the guard house. However, security guards are authorized to inspect school bags and other belongings if necessary.</li>
                    <h5 class="mb-3">INSTITUTION POLICY AGAINST SEXUAL HARASSMENT</h5>
                    <li><b>•</b><B>St. Mary's College of Bansalan </b> is committed to ensuring that the workplace, training, and education environment is free from sexual harassment. Sexual harassment is a form of misconduct that undermines employment and/or educational relationships. No employee or student, either male or female, should be subjected verbally or physically to unsolicited and unwelcome sexual overtures or conduct; that it will not be tolerated under any 
                    circumstances and that disciplinary action can be taken against any employee or students who breaches the policy.</li>

                </ul>

                <h5 class="mb-3">A. DEFINITION OF SEXUAL HARASSMENT</h5>
                <ul>
                    <li><b>•</b><b>St. Mary's College of Bansalan </b> has adopted and its policy is based on the definition of sexual harassment set forth in 
                    <b>Section 3 or R.A. 7877.</b> It provides that work, education or training-related sexual harassment is committed by an employer, employee, manager, supervisor, teacher, instructor, coach or any other person who, having authority, influence or moral ascendancy over another in a work, training or education environment, demands, requests or otherwise requires any sexual favor from the other, regardless of whether the demand, request or requirement for submission is accepted by the object of said Act.
.</li>
<h5 class="mb-3"><b>•</b> <b>In a work-related or employment environment, sexual harassment is committed when:</b></h5>
<ul>
    <li><b>1.</b> The submission to or rejection of the act or series of acts is used as basis for any employment decision (including but not limited to, matters related to hiring, promotion, raises in salary, job security, benefits and any other personnel action) affecting the applicant/employee; or</li>
    <li><b>2.</b> The act or series of acts have the purpose or effect of interfering with complainant's work performance, or creating an intimidating, hostile or offensive work environment; or</li>
    <li><b>3.</b> The act or series of acts might reasonably be expected to cause discrimination, insecurity, discomfort, offense, or humiliation to a complainant who may be a trainee, apprentice, intern, tutee or ward of the person complained of.</li>
</ul>

<h5 class="mb-3"><b>•</b> <b>In an education or training environment, sexual harassment is committed when:</b></h5>
<ul>
    <li><b>1.</b> The submission to or rejection of the act or series of acts is used as a basis for any decision affecting the complainant, including, but not limited to, the giving of a grade, the granting of honors or a scholarship, the payment of a stipend or allowance, or the giving of any benefit, privilege, or consideration; or</li>
    <li><b>2.</b> The act or series of acts have the purpose or effect of interfering with the performance, or creating an intimidating, hostile or offensive academic environment of the complainant; or</li>
    <li><b>3.</b> The act or series of acts might reasonably be expected to cause discrimination, insecurity, discomfort, offense, or humiliation to a complainant who may be a trainee, apprentice, intern, tutee or ward of the person complained of.</li>
</ul>

<h5 class="mb-3">B. WHERE SEXUAL HARASSMENT IS COMMITTED</h5>
<p><b>Sexual harassment may be committed in any work, training, or education environment. It may include, but not be limited to the following:</b></p>
<ol>
    <li><b>1.</b>In or outside the office building, classroom, or training site;</li>
    <li><b>2.</b>At office, or training, or education-related social functions;</li>
    <li><b>3.</b>In the course of work assignments outside the office;</li>
    <li><b>4.</b>At work-related conferences, studies or training sessions;</li>
    <li><b>5.</b>During work, education related travel.</li>
</ol>

<h5 class="mb-3">C. FORMS OF SEXUAL HARASSMENT</h5>
<p><b>Sexual harassment may be committed in any of the following forms:</b></p>
<ol>
    <li><b>1.</b> Physical
        <ul style="list-style-type: lower-alpha;">
            <li>Malicious touching;</li>
            <li>Overt sexual advances;</li>
                        <li>Unwelcome or improper gestures of affection;</li>
            <li>Any other act or conduct of a sexual nature, or for the purpose of sexual gratification which is generally annoying, disgusting or offensive to the victim</li>
        </ul>
    </li>

    <li>2. Verbal such as request or demand for sexual favors including but not limited to going out on dates, outings, fieldtrip, or the like for the same purpose, and lurid remarks and Display, transmittal or use of offensive objects, pictures or graphics, letters or written notes with sexual underpinnings
        
            
        </ul>
    </li>

    
</ol>

<h5 class="mb-3">D. WHAT IS NOT SEXUAL HARASSMENT</h5>
<p>
    Sexual harassment does not refer to occasional compliments of a socially acceptable nature. It is not a behavior which is based on mutual attraction, friendship, and respect. If the interaction is consensual, welcome and reciprocated, it is not sexual harassment.
</p>

<h5 class="mb-3">E. EMPLOYER’S RESPONSIBILITY</h5>
<p>
    <b>St. Mary's College of Bansalan</b> shall provide its officers, employees, and students a work and education environment free of sexual harassment by management personnel, by coworkers, students, and by others with whom officers, employees, and students must interact in the course of their employment and education in the institution.
</p>
<p>
    Sexual harassment is specifically prohibited as unlawful and as a violation of the institution's policy. The institution is responsible for preventing sexual harassment in the workplace, for taking immediate corrective action to stop sexual harassment in the education environment and for promptly investigating any allegation of work and education related sexual harassment.
</p>

<h5 class="mb-3">II. PROCEDURES ON SEXUAL HARASSMENT</h5>

<p>
    Any officer or employee, who experiences or witnesses any act of sexual harassment in the workplace, shall report the same immediately to the <b>Committee on Decorum and Investigation</b>. They may also report acts of sexual harassment  cases. The Committee shall also develop and implement programs to increase understanding and awareness about sexual harassment.
  </p>

<h5 class="mb-3">B. Retaliation</h5>
  <p>
    St. Mary’s College of Bansalan will permit no employment-based retaliation against anyone who brings a complaint of sexual harassment or who speaks as a witness in the investigation of a complaint of sexual harassment.
  </p>

 <h5 class="mb-3">C. Written Policy </h5>
  <p>
    All officers, employees and students of <strong>St. Mary’s College of Bansalan</strong> shall receive a copy of the institution’s sexual harassment policy upon assumption of their respective offices. If at any time an officer or employee would like another copy of the policy, please contact the Office of the Committee on Decorum. If <strong>St. Mary’s College of Bansalan</strong> should amend or modify its sexual harassment policy, all officers and employees will receive an individual copy of the amended or modified policy.
  </p>

   <h5 class="mb-3">D. Effectivity </h5>
  <p>
    This policy shall take effect immediately and shall be known to all employees and students.
  </p>


        </ul>
    </li>
</ol>


                </ul>
            </div>
            <div class="modal-footer">
              
            </div>
        </div>
    </div>
</div>

            </div>
        </div>
    </div>
</div>












<!-- js -->
		<script assets/src="assets/vendors/scripts/core.js"></script>
		<script assets/src="assets/vendors/scripts/script.min.js"></script>
		<script assets/src="assets/vendors/scripts/process.js"></script>
		<script assets/src="assets/vendors/scripts/layout-settings.js"></script>
		<!-- fancybox Popup Js -->
		<script assets/src="assets/src/plugins/fancybox/dist/jquery.fancybox.js"></script>
	</body>
</html>
