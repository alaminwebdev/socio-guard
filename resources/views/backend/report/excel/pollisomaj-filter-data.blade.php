{{-- <table class="table table-bordered">
    <thead>
        <tr>
            <th colspan="10" style="background-color: aqua; text-align: center"> Community Mobilization Data Entry </th>
            
        </tr>
    </thead>
</table> --}}
<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
<table class="table table-bordered">
    <thead>
        <tr>
            {{-- Step 1 --}}
            <th style="background-color: #cfcfcf;">Reporting Date</th>
            <th style="background-color: #cfcfcf;">PS Data Entry No.</th>
            <th style="background-color: #cfcfcf;">Zone</th>
            <th style="background-color: #cfcfcf;">Division</th>
            <th style="background-color: #cfcfcf;">District</th>
            <th style="background-color: #cfcfcf;">Upazila</th>
            <th style="background-color: #cfcfcf;">Union</th>
            <th style="background-color: #cfcfcf;">Village</th>
            <th style="background-color: #cfcfcf;">Ward</th>
            <th style="background-color: #cfcfcf;">Pollisomaj No</th>
            <th style="background-color: #cfcfcf;">Pollisomaj Name</th>
            <th style="background-color: #cfcfcf;">Date of pollisomaj Reformation</th>
            <th style="background-color: #cfcfcf;">Member(Girls)</th>
            <th style="background-color: #cfcfcf;">Member(Boys)</th>
            <th style="background-color: #cfcfcf;">Member(Female)</th>
            <th style="background-color: #cfcfcf;">Member(Male)</th>
            <th style="background-color: #cfcfcf;">Member(Transgender)</th>
            <th style="background-color: #cfcfcf;">Member(Total)</th>
            <th style="background-color: #cfcfcf;">Member PWD(Girls)</th>
            <th style="background-color: #cfcfcf;">Member PWD(Boys)</th>
            <th style="background-color: #cfcfcf;">Member PWD(Female)</th>
            <th style="background-color: #cfcfcf;">Member PWD(Male)</th>
            <th style="background-color: #cfcfcf;">Member PWD(Transgender)</th>
            <th style="background-color: #cfcfcf;">Member PWD(Total)</th>
            <th style="background-color: #cfcfcf;">President Contact Number</th>
            <th style="background-color: #cfcfcf;">Secretary Contact Number</th>
            <th style="background-color: #cfcfcf;">Cashier Contact Number</th>
            
            {{-- Step 2 --}}
            <th style="background-color: #cfcfcf;">Number of Child Marriage Reported</th>
            <th style="background-color: #cfcfcf;">Contacted Up Within PS Member</th>
            <th style="background-color: #cfcfcf;">Contacted Up Beyond PS Member</th>
            <th style="background-color: #cfcfcf;">Contacted Local Within Thana Member</th>
            <th style="background-color: #cfcfcf;">Contacted Local Beyond Thana Member</th>
            <th style="background-color: #cfcfcf;">Family Consultation Within PS Member</th>
            <th style="background-color: #cfcfcf;">Family Consultation Beyond PS Member</th>
            <th style="background-color: #cfcfcf;">Contacted Upazila Within PS Member</th>
            <th style="background-color: #cfcfcf;">Contacted Upazila Beyond PS Member</th>
            <th style="background-color: #cfcfcf;">Hotline Number Within PS Member</th>
            <th style="background-color: #cfcfcf;">Hotline Number Beyond PS Member</th>
            <th style="background-color: #cfcfcf;">Girls Risk of Child Marriage</th>
            <th style="background-color: #cfcfcf;">Girls Risk of Child PWD</th>
            <th style="background-color: #cfcfcf;">Card Provided Among Girls</th>
            <th style="background-color: #cfcfcf;">Card Provided Among PWD</th>
            <th style="background-color: #cfcfcf;">Girls Connected to Service</th>
            <th style="background-color: #cfcfcf;">Girls Connected to Service PWD</th>
            <th style="background-color: #cfcfcf;">Girls Got Married Finally</th>
            <th style="background-color: #cfcfcf;">Girls Got Married Finally PWD</th>
            <th style="background-color: #cfcfcf;">Girls Got Married at 18 Finally</th>
            <th style="background-color: #cfcfcf;">Girls Got Married under 18 Finally PWD</th>
            <th style="background-color: #cfcfcf;">Illegal Divorce</th>
            <th style="background-color: #cfcfcf;">Illegal Polygamy</th>
            <th style="background-color: #cfcfcf;">Family Conflict</th>
            <th style="background-color: #cfcfcf;">Hilla Marriage</th>
            <th style="background-color: #cfcfcf;">Illegal Arbitration</th>
            <th style="background-color: #cfcfcf;">Illegal Fatwah</th>
            <th style="background-color: #cfcfcf;">Physical Torture</th>
            <th style="background-color: #cfcfcf;">Sexual Harassment</th>
            
            {{-- Step 3 --}}

            <th style="background-color: #cfcfcf;">PS Member GOV. Election Men</th>
            <th style="background-color: #cfcfcf;">PS Member GOV. Election Women</th>
            <th style="background-color: #cfcfcf;">PS Member GOV. Election Transgender</th>
            <th style="background-color: #cfcfcf;">PS Member GOV. Election PWD</th>
            <th style="background-color: #cfcfcf;">PS Member GOV. Election Men Elected</th>
            <th style="background-color: #cfcfcf;">PS Member GOV. Election Women Elected</th>
            <th style="background-color: #cfcfcf;">PS Member GOV. Election Transgender Elected</th>
            <th style="background-color: #cfcfcf;">PS Member GOV. Election PWD Elected</th>
            <th style="background-color: #cfcfcf;">Contested as Joyeeta</th>
            <th style="background-color: #cfcfcf;">Joyeeta Contested Women</th>

            <th style="background-color: #cfcfcf;">Joyeeta Contested PWDd</th>
            <th style="background-color: #cfcfcf;">Joyeeta District Selected</th>
            <th style="background-color: #cfcfcf;">Joyeeta Division Selected</th>
            <th style="background-color: #cfcfcf;">Joyeeta National Selected</th>
            <th style="background-color: #cfcfcf;">School Committee Boys</th>
            <th style="background-color: #cfcfcf;">School Committee Girls</th>
            <th style="background-color: #cfcfcf;">School Committee Male</th>
            <th style="background-color: #cfcfcf;">School Committee Female</th>
            <th style="background-color: #cfcfcf;">School Committee Transgender</th>
            <th style="background-color: #cfcfcf;">School Committee Total</th>

            <th style="background-color: #cfcfcf;">School Committee PWD Boys</th>
            <th style="background-color: #cfcfcf;">School Committee PWD Girls</th>
            <th style="background-color: #cfcfcf;">School Committee PWD Male</th>
            <th style="background-color: #cfcfcf;">School Committee PWD Female</th>
            <th style="background-color: #cfcfcf;">School Committee PWD Transgender</th>
            <th style="background-color: #cfcfcf;">School Committee PWD Total</th>
            <th style="background-color: #cfcfcf;">Hatbazar Committee Boys</th>
            <th style="background-color: #cfcfcf;">Hatbazar Committee Girls</th>
            <th style="background-color: #cfcfcf;">Hatbazar Committee Male</th>
            <th style="background-color: #cfcfcf;">Hatbazar Committee Female</th>

            <th style="background-color: #cfcfcf;">Hatbazar Committee Transgender</th>
            <th style="background-color: #cfcfcf;">Hatbazar Committee Total</th>
            <th style="background-color: #cfcfcf;">Hatbazar Committee PWD Boys</th>
            <th style="background-color: #cfcfcf;">Hatbazar Committee PWD Girls</th>
            <th style="background-color: #cfcfcf;">Hatbazar Committee PWD Male</th>
            <th style="background-color: #cfcfcf;">Hatbazar Committee PWD Female</th>
            <th style="background-color: #cfcfcf;">Hatbazar Committee PWD Transgender</th>
            <th style="background-color: #cfcfcf;">Hatbazar Committee PWD Total</th>
            <th style="background-color: #cfcfcf;">Stading Committee Boys</th>
            <th style="background-color: #cfcfcf;">Stading Committee Girls</th>

            <th style="background-color: #cfcfcf;">Stading Committee Male</th>
            <th style="background-color: #cfcfcf;">Stading Committee Female</th>
            <th style="background-color: #cfcfcf;">Stading Committee Transgender</th>
            <th style="background-color: #cfcfcf;">Stading Committee Total</th>
            <th style="background-color: #cfcfcf;">Stading Committee PWD Boys</th>
            <th style="background-color: #cfcfcf;">Stading Committee PWD Girls</th>
            <th style="background-color: #cfcfcf;">Stading Committee PWD Male</th>
            <th style="background-color: #cfcfcf;">Stading Committee PWD Female</th>
            <th style="background-color: #cfcfcf;">Stading Committee PWD Transgender</th>
            <th style="background-color: #cfcfcf;">Stading Committee PWD Total</th>

            <th style="background-color: #cfcfcf;">Clinic Committee Boys</th>
            <th style="background-color: #cfcfcf;">Clinic Committee Girls</th>
            <th style="background-color: #cfcfcf;">Clinic Committee Male</th>
            <th style="background-color: #cfcfcf;">Clinic Committee Female</th>
            <th style="background-color: #cfcfcf;">Clinic Committee Transgender</th>
            <th style="background-color: #cfcfcf;">Clinic Committee Total</th>
            <th style="background-color: #cfcfcf;">Clinic Committee PWD Boys</th>
            <th style="background-color: #cfcfcf;">Clinic Committee PWD Girls</th>
            <th style="background-color: #cfcfcf;">Clinic Committee PWD Male</th>
            <th style="background-color: #cfcfcf;">Clinic Committee PWD Female</th>

            <th style="background-color: #cfcfcf;">Clinic Committee PWD Transgender</th>
            <th style="background-color: #cfcfcf;">Clinic Committee PWD Total</th>
            <th style="background-color: #cfcfcf;">Institution Committee Boys</th>
            <th style="background-color: #cfcfcf;">Institution Committee Girls</th>
            <th style="background-color: #cfcfcf;">Institution Committee Male</th>
            <th style="background-color: #cfcfcf;">Institution Committee Female</th>
            <th style="background-color: #cfcfcf;">Institution Committee Transgender</th>
            <th style="background-color: #cfcfcf;">Institution Committee Total</th>
            <th style="background-color: #cfcfcf;">Institution Committee PWD Boys</th>
            <th style="background-color: #cfcfcf;">Institution Committee PWD Girls</th>

            <th style="background-color: #cfcfcf;">Institution Committee PWD Male</th>
            <th style="background-color: #cfcfcf;">Institution Committee PWD Female</th>
            <th style="background-color: #cfcfcf;">Institution Committee PWD Transgender</th>
            <th style="background-color: #cfcfcf;">Institution Committee PWD Total</th>
            <th style="background-color: #cfcfcf;">Solidarity Committee Boys</th>
            <th style="background-color: #cfcfcf;">Solidarity Committee Girls</th>
            <th style="background-color: #cfcfcf;">Solidarity Committee Male</th>
            <th style="background-color: #cfcfcf;">Solidarity Committee Female</th>
            <th style="background-color: #cfcfcf;">Solidarity Committee Transgender</th>
            <th style="background-color: #cfcfcf;">Solidarity Committee Total</th>

            <th style="background-color: #cfcfcf;">Solidarity Committee PWD Boys</th>
            <th style="background-color: #cfcfcf;">Solidarity Committee PWD Girls</th>
            <th style="background-color: #cfcfcf;">Solidarity Committee PWD Male</th>
            <th style="background-color: #cfcfcf;">Solidarity Committee PWD Female</th>
            <th style="background-color: #cfcfcf;">Solidarity Committee PWD Transgender</th>
            <th style="background-color: #cfcfcf;">Solidarity Committee PWD Total</th>
            <th style="background-color: #cfcfcf;">Welfare Committee Boys</th>
            <th style="background-color: #cfcfcf;">Welfare Committee Girls</th>
            <th style="background-color: #cfcfcf;">Welfare Committee Male</th>
            <th style="background-color: #cfcfcf;">Welfare Committee Female</th>

            <th style="background-color: #cfcfcf;">Welfare Committee Transgender</th>
            <th style="background-color: #cfcfcf;">Welfare Committee Total</th>
            <th style="background-color: #cfcfcf;">Welfare Committee PWD Boys</th>
            <th style="background-color: #cfcfcf;">Welfare Committee PWD Girls</th>
            <th style="background-color: #cfcfcf;">Welfare Committee PWD Male</th>
            <th style="background-color: #cfcfcf;">Welfare Committee PWD Female</th>
            <th style="background-color: #cfcfcf;">Welfare Committee PWD Transgender</th>
            <th style="background-color: #cfcfcf;">Welfare Committee PWD Total</th>
            
            {{-- Step 4 --}}
            
            <th style="background-color: #cfcfcf;">IGA Training Financial PS Member Boys</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial PS Member Girls</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial PS Member Male</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial PS Member Female</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial PS Member Transgender</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial PS Member Total</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial PS Member PWD Boys</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial PS Member PWD Girls</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial PS Member PWD Male</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial PS Member PWD Female</th>

            <th style="background-color: #cfcfcf;">IGA Training Financial PS Member PWD Transgender</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial PS Member PWD Total</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial Without PS Member Boys</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial Without PS Member Girls</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial Without PS Member Male</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial Without PS Member Female</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial Without PS Member Transgender</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial Without PS Member Total</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial Without PS Member  PWD Boys</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial Without PS Member  PWD Girls</th>

            <th style="background-color: #cfcfcf;">IGA Training Financial Without PS Member  PWD Male</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial Without PS Member  PWD Female</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial Without PS Member  PWD Transgender</th>
            <th style="background-color: #cfcfcf;">IGA Training Financial Without PS Member  PWD Total</th>
            <th style="background-color: #cfcfcf;">IGA Training PS Member Boys</th>
            <th style="background-color: #cfcfcf;">IGA Training PS Member Girls</th>
            <th style="background-color: #cfcfcf;">IGA Training PS Member Men</th>
            <th style="background-color: #cfcfcf;">IGA Training PS Member Women</th>
            <th style="background-color: #cfcfcf;">IGA Training PS Member Transgender</th>
            <th style="background-color: #cfcfcf;">IGA Training PS Member Total</th>
            <th style="background-color: #cfcfcf;">IGA Training PS Member PWD Boys</th>

            <th style="background-color: #cfcfcf;">IGA Training PS Member PWD Girls</th>
            <th style="background-color: #cfcfcf;">IGA Training PS Member PWD Men</th>
            <th style="background-color: #cfcfcf;">IGA Training PS Member PWD Women</th>
            <th style="background-color: #cfcfcf;">IGA Training PS Member PWD Transgender</th>
            <th style="background-color: #cfcfcf;">IGA Training PS Member PWD Total</th>
            <th style="background-color: #cfcfcf;">IGA Training Without PS Memeber Boys</th>
            <th style="background-color: #cfcfcf;">IGA Training Without PS Memeber Girls</th>
            <th style="background-color: #cfcfcf;">IGA Training Without PS Memeber Men</th>
            <th style="background-color: #cfcfcf;">IGA Training Without PS Memeber Women</th>
            <th style="background-color: #cfcfcf;">IGA Training Without PS Memeber Transgender</th>

            <th style="background-color: #cfcfcf;">IGA Training Without PS Memeber Total</th>
            <th style="background-color: #cfcfcf;">IGA Training Without PS Memeber PWD Boys</th>
            <th style="background-color: #cfcfcf;">IGA Training Without PS Memeber PWD Girls</th>
            <th style="background-color: #cfcfcf;">IGA Training Without PS Memeber PWD Men</th>
            <th style="background-color: #cfcfcf;">IGA Training Without PS Memeber PWD Women</th>
            <th style="background-color: #cfcfcf;">IGA Training Without PS Memeber PWD Transgender</th>
            <th style="background-color: #cfcfcf;">IGA Training Without PS Memeber PWD Total</th>
            
            {{-- Step 6 --}}
            <th style="background-color: #cfcfcf;">Number of Session with Men</th>
            <th style="background-color: #cfcfcf;">Session With Men Total</th>
            <th style="background-color: #cfcfcf;">Session With Men PWD Total</th>
            <th style="background-color: #cfcfcf;">Number of Session with Women</th>
            <th style="background-color: #cfcfcf;">Session With Women Total</th>
            <th style="background-color: #cfcfcf;">Session With Women PWD Total</th>
            <th style="background-color: #cfcfcf;">Number of Session with Adolescents</th>
            <th style="background-color: #cfcfcf;">Session With Adolescent Boys</th>
            <th style="background-color: #cfcfcf;">Session With Adolescent Girls</th>
            <th style="background-color: #cfcfcf;">Session With Adolescent Total</th>
            <th style="background-color: #cfcfcf;">Session With Adolescent PWD Total</th>
            <th style="background-color: #cfcfcf;">Number of sessions with PS</th>
            <th style="background-color: #cfcfcf;">Session With PS Boys</th>
            <th style="background-color: #cfcfcf;">Session With PS Girls</th>
            <th style="background-color: #cfcfcf;">Session With PS Men</th>
            <th style="background-color: #cfcfcf;">Session With PS Women</th>
            <th style="background-color: #cfcfcf;">Session With PS Transgender</th>
            <th style="background-color: #cfcfcf;">Session With PS PWD</th>
            <th style="background-color: #cfcfcf;">Session With PS Total</th>
            <th style="background-color: #cfcfcf;">Capacity Building Training by SELP Boy</th>
            <th style="background-color: #cfcfcf;">Capacity Building Training by SELP Girls</th>
            <th style="background-color: #cfcfcf;">Capacity Building Training by SELP Men</th>
            <th style="background-color: #cfcfcf;">Capacity Building Training by SELP Women</th>
            <th style="background-color: #cfcfcf;">Capacity Building Training by SELP Transgender</th>
            <th style="background-color: #cfcfcf;">Capacity Building Training by SELP Total</th>
            <th style="background-color: #cfcfcf;">Capacity Building Training by SELP Boy PWD</th>
            <th style="background-color: #cfcfcf;">Capacity Building Training by SELP Girls PWD</th>
            <th style="background-color: #cfcfcf;">Capacity Building Training by SELP Men PWD</th>
            <th style="background-color: #cfcfcf;">Capacity Building Training by SELP Women PWD</th>
            <th style="background-color: #cfcfcf;">Capacity Building Training by SELP Girls Transgender</th>
            <th style="background-color: #cfcfcf;">Capacity Building Training by SELP PWD Total</th>
            
            {{-- Step 7 --}}
            {{-- <th style="background-color: #cfcfcf;">Womens Day Celebration Boy</th>
            <th style="background-color: #cfcfcf;">Womens Day Celebration Girls</th>
            <th style="background-color: #cfcfcf;">Womens Day Celebration Men</th>
            <th style="background-color: #cfcfcf;">Womens Day Celebration Women</th>
            <th style="background-color: #cfcfcf;">Womens Day Celebration Transgender</th>
            <th style="background-color: #cfcfcf;">Womens Day Celebration Total</th>
            <th style="background-color: #cfcfcf;">Womens Day Celebration date</th>
            <th style="background-color: #cfcfcf;">Womens Day Celebration PWD Boy</th>
            <th style="background-color: #cfcfcf;">Womens Day Celebration PWD Girls</th>
            <th style="background-color: #cfcfcf;">Womens Day Celebration PWD Men</th>
            <th style="background-color: #cfcfcf;">Womens Day Celebration PWD Women</th>
            <th style="background-color: #cfcfcf;">Womens Day Celebration PWD Transgender</th>
            <th style="background-color: #cfcfcf;">Womens Day Celebration PWD Total</th>
            <th style="background-color: #cfcfcf;">Celebration Days Campaign Boy</th>
            <th style="background-color: #cfcfcf;">Celebration Days Campaign Girls</th>
            <th style="background-color: #cfcfcf;">Celebration Days Campaign Men</th>
            <th style="background-color: #cfcfcf;">Celebration Days Campaign Women</th>
            <th style="background-color: #cfcfcf;">Celebration Days Campaign Transgender</th>
            <th style="background-color: #cfcfcf;">Celebration Days Campaign Total</th>
            <th style="background-color: #cfcfcf;">Celebration Days Campaign date</th>
            <th style="background-color: #cfcfcf;">Celebration Days Campaign PWD Boy</th>
            <th style="background-color: #cfcfcf;">Celebration Days Campaign PWD Girls</th>
            <th style="background-color: #cfcfcf;">Celebration Days Campaign PWD Men</th>
            <th style="background-color: #cfcfcf;">Celebration Days Campaign PWD Women</th>
            <th style="background-color: #cfcfcf;">Celebration Days Campaign PWD Transgender</th>
            <th style="background-color: #cfcfcf;">celebration_days_campaign_PWD Total</th>
            <th style="background-color: #cfcfcf;">Legal Aid Days Boy</th>
            <th style="background-color: #cfcfcf;">Legal Aid Days Girls</th>
            <th style="background-color: #cfcfcf;">Legal Aid Days Men</th>
            <th style="background-color: #cfcfcf;">Legal Aid Days Women</th>
            <th style="background-color: #cfcfcf;">Legal Aid Days Transgender</th>
            <th style="background-color: #cfcfcf;">Legal Aid Days Total</th>
            <th style="background-color: #cfcfcf;">Legal Aid Days date</th>
            <th style="background-color: #cfcfcf;">Legal Aid Days PWD Boy</th>
            <th style="background-color: #cfcfcf;">Legal Aid Days PWD Girls</th>
            <th style="background-color: #cfcfcf;">Legal Aid Days PWD Men</th>
            <th style="background-color: #cfcfcf;">Legal Aid Days PWD Women</th>
            <th style="background-color: #cfcfcf;">Legal Aid Days PWD Transgender</th>
            <th style="background-color: #cfcfcf;">Legal Aid Days PWD Total</th> --}}
            
            {{-- Step 8 --}}
            {{-- <th style="background-color: #cfcfcf;">Social Cohesion Event</th>
            <th style="background-color: #cfcfcf;">Social Cohesion Event_date</th>
            <th style="background-color: #cfcfcf;">Social Cohesion Event Participent Girl</th>
            <th style="background-color: #cfcfcf;">Social Cohesion Event Participent Boy</th>
            <th style="background-color: #cfcfcf;">Social Cohesion Event Participent Women</th>
            <th style="background-color: #cfcfcf;">Social Cohesion Event Participent Men</th>
            <th style="background-color: #cfcfcf;">Social Cohesion Event Participent Transgender</th>
            <th style="background-color: #cfcfcf;">social_cohesion_event Participent Total</th>
            <th style="background-color: #cfcfcf;">Upazila Stakeholder Meeting</th>
            <th style="background-color: #cfcfcf;">Upazila Stakeholder Meeting Date</th>
            <th style="background-color: #cfcfcf;">Upazila Stakeholder Meeting Participent Men gob</th>
            <th style="background-color: #cfcfcf;">Upazila Stakeholder Meeting Participent Women gob</th>
            <th style="background-color: #cfcfcf;">Upazila Stakeholder Meeting Participent Boy</th>
            <th style="background-color: #cfcfcf;">Upazila Stakeholder Meeting Participent Girl</th>
            <th style="background-color: #cfcfcf;">Upazila Stakeholder Meeting Participent Men</th>
            <th style="background-color: #cfcfcf;">Upazila Stakeholder Meeting Participent Women</th>
            <th style="background-color: #cfcfcf;">Upazila Stakeholder Meeting Participent Transgender</th>
            <th style="background-color: #cfcfcf;">Upazila Stakeholder Meeting Participent Total</th>
            <th style="background-color: #cfcfcf;">Upazila Stakeholder Meeting Participent PWD Boy</th>
            <th style="background-color: #cfcfcf;">Upazila Stakeholder Meeting Participent PWD Girl</th>
            <th style="background-color: #cfcfcf;">Upazila Stakeholder Meeting Participent PWD Men</th>
            <th style="background-color: #cfcfcf;">Upazila Stakeholder Meeting Participent PWD Women</th>
            <th style="background-color: #cfcfcf;">Upazila Stakeholder Meeting Participent PWD Transgender</th>
            <th style="background-color: #cfcfcf;">Upazila Stakeholder Meeting Participent PWD Total</th> --}}
            
            {{-- Step 9 --}}
            {{-- <th style="background-color: #cfcfcf;">Panel Staff Workshop</th>
            <th style="background-color: #cfcfcf;">Panel Staff Date</th>
            <th style="background-color: #cfcfcf;">Panel Lawyer</th>
            <th style="background-color: #cfcfcf;">Panel Lawyer Date</th>
            <th style="background-color: #cfcfcf;">External Network DLAC Meeting</th>
            <th style="background-color: #cfcfcf;">External Network DLAC Meeting Male</th>
            <th style="background-color: #cfcfcf;">External Network DLAC Meeting Female</th>
            <th style="background-color: #cfcfcf;">External Network DLAC Meeting Total</th>
            <th style="background-color: #cfcfcf;">External Network DLAC Meeting Date</th>
            <th style="background-color: #cfcfcf;">PT Group</th>
            <th style="background-color: #cfcfcf;">PT Group Performer Boy</th>
            <th style="background-color: #cfcfcf;">PT Group Performer Girl</th>
            <th style="background-color: #cfcfcf;">PT Group Performer Men</th>
            <th style="background-color: #cfcfcf;">PT Group Performer Women</th>
            <th style="background-color: #cfcfcf;">PT Group Performer Transgender</th>
            <th style="background-color: #cfcfcf;">PT Group Performer Total</th>
            <th style="background-color: #cfcfcf;">PT Group Performer Boy_pwd</th>
            <th style="background-color: #cfcfcf;">PT Group Performer Girl_pwd</th>
            <th style="background-color: #cfcfcf;">PT Group Performer Men_pwd</th>
            <th style="background-color: #cfcfcf;">PT Group Performer Women_pwd</th>
            <th style="background-color: #cfcfcf;">PT Group Performer Transgender PWD</th>
            <th style="background-color: #cfcfcf;">PT Group Performer  PWD Total</th> --}}

            {{-- Step 10 --}}
            {{-- <th style="background-color: #cfcfcf;">Production Workshop SPA</th>
            <th style="background-color: #cfcfcf;">Production Workshop Cost Recovery</th>
            <th style="background-color: #cfcfcf;">Production Workshop Project</th>
            <th style="background-color: #cfcfcf;">Production Workshop Special</th>
            <th style="background-color: #cfcfcf;">Production Workshop Other</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach($pollisomaj as $data)
        <tr>
            {{-- Step 1 --}}
            <td>{{ @$data['reporting_date'] == null ? '' : @$data['reporting_date']}}</td>
            <td>{{ @$data['id'] }}</td>
            <td>{{ @$data['zones']['region_name'] }}</td>
            <td>{{ @$data['division']['name'] }}</td>
            <td>{{ @$data['district']['name'] }}</td>
            <td>{{ @$data['upazilla']['name'] }}</td>
            <td>{{ @$data['union']['name'] }}</td>
            <td>{{ @$data['village_name'] }}</td>
            <td>{{ @$data['ward_no'] }}</td>
            <td>{{ @$data['pollisomaj_no'] }}</td>
            <td>{{ @$data['pollisomaj_info']['pollisomaj_name'] }}</td>
            <td>{{ @$data['ps_reform_date'] }}</td>
            <td>{{ @$data['member_girls'] }}</td>
            <td>{{ @$data['member_boys'] }}</td>
            <td>{{ @$data['member_female'] }}</td>
            <td>{{ @$data['member_male'] }}</td>
            <td>{{ @$data['member_transgender'] }}</td>
            <td>{{ @$data['general_member_total'] }}</td>
            <td>{{ @$data['member_girls_pwd'] }}</td>
            <td>{{ @$data['member_boys_pwd'] }}</td>
            <td>{{ @$data['member_female_pwd'] }}</td>
            <td>{{ @$data['member_male_pwd'] }}</td>
            <td>{{ @$data['member_transgender_pwd'] }}</td>
            <td>{{ @$data['general_member_pwd_total'] }}</td>
            <td>{{ @$data['p_number'] }}</td>
            <td>{{ @$data['s_number'] }}</td>
            <td>{{ @$data['c_number'] }}</td>
            
            {{-- Step 2 --}}
            <td>{{ @$data['number_of_child_marriage'] }}</td>
            <td>{{ @$data['contacted_up_within_ps_member'] }}</td>
            <td>{{ @$data['contacted_up_beyond_ps_member'] }}</td>
            <td>{{ @$data['contacted_local_within_ps_member'] }}</td>
            <td>{{ @$data['contacted_local_beyond_ps_member'] }}</td>
            <td>{{ @$data['family_consultation_within_ps_member'] }}</td>
            <td>{{ @$data['family_consultation_beyond_ps_member'] }}</td>
            <td>{{ @$data['contacted_upazila_within_ps_member'] }}</td>
            <td>{{ @$data['contacted_upazila_beyond_ps_member'] }}</td>
            <td>{{ @$data['hotline_number_within_ps_member'] }}</td>
            <td>{{ @$data['hotline_number_beyond_ps_member'] }}</td>
            <td>{{ @$data['girls_risk_of_child_marriage'] }}</td>
            <td>{{ @$data['girls_risk_of_child_marriage_pwd'] }}</td>
            <td>{{ @$data['card_provided_among_girls'] }}</td>
            <td>{{ @$data['card_provided_among_pwd'] }}</td>
            <td>{{ @$data['girls_connected_to_service'] }}</td>
            <td>{{ @$data['girls_connected_to_service_pwd'] }}</td>
            <td>{{ @$data['girls_got_married_finally'] }}</td>
            <td>{{ @$data['girls_got_married_finally_pwd'] }}</td>
            <td>{{ @$data['girls_got_married_at_18_finally'] }}</td>
            <td>{{ @$data['girls_got_married_under_18_finally_pwd'] }}</td>
            <td>{{ @$data['illegal_divorce'] }}</td>
            <td>{{ @$data['illegal_polygamy'] }}</td>
            <td>{{ @$data['family_conflict'] }}</td>
            <td>{{ @$data['hilla_marriage'] }}</td>
            <td>{{ @$data['illegal_arbitration'] }}</td>
            <td>{{ @$data['illegal_fatwah'] }}</td>
            <td>{{ @$data['physical_torture'] }}</td>
            <td>{{ @$data['sexual_harassment'] }}</td>
            
            {{-- Step 3 --}}
            <td>{{ @$data['ps_mem_gov_elec_men'] }}</td>
            <td>{{ @$data['ps_mem_gov_elec_women'] }}</td>
            <td>{{ @$data['ps_mem_gov_elec_transgender'] }}</td>
            <td>{{ @$data['ps_mem_gov_elec_pwd'] }}</td>
            <td>{{ @$data['ps_mem_gov_elec_men_elected'] }}</td>
            <td>{{ @$data['ps_mem_gov_elec_women_elected'] }}</td>
            <td>{{ @$data['ps_mem_gov_elec_transgender_elected'] }}</td>
            <td>{{ @$data['ps_mem_gov_elec_pwd_elected'] }}</td>
            <td>{{ @$data['contested_as_joyeeta'] }}</td>
            <td>{{ @$data['joyeeta_contested_women'] }}</td>

            <td>{{ @$data['joyeeta_contested_pwd'] }}</td>
            <td>{{ @$data['joyeeta_dis_selected'] }}</td>
            <td>{{ @$data['joyeeta_div_selected'] }}</td>
            <td>{{ @$data['joyeeta_national_selected'] }}</td>
            <td>{{ @$data['school_committee_boys'] }}</td>
            <td>{{ @$data['school_committee_girls'] }}</td>
            <td>{{ @$data['school_committee_male'] }}</td>
            <td>{{ @$data['school_committee_female'] }}</td>
            <td>{{ @$data['school_committee_transgender'] }}</td>
            <td>{{ @$data['school_committee_total'] }}</td>
            
            <td>{{ @$data['school_committee_pwd_boys'] }}</td>
            <td>{{ @$data['school_committee_pwd_girls'] }}</td>
            <td>{{ @$data['school_committee_pwd_male'] }}</td>
            <td>{{ @$data['school_committee_pwd_female'] }}</td>
            <td>{{ @$data['school_committee_pwd_transgender'] }}</td>
            <td>{{ @$data['school_committee_pwd_total'] }}</td>
            <td>{{ @$data['hatbazar_committee_boys'] }}</td>
            <td>{{ @$data['hatbazar_committee_girls'] }}</td>
            <td>{{ @$data['hatbazar_committee_male'] }}</td>
            <td>{{ @$data['hatbazar_committee_female'] }}</td>

            <td>{{ @$data['hatbazar_committee_transgender'] }}</td>
            <td>{{ @$data['hatbazar_committee_total'] }}</td>
            <td>{{ @$data['hatbazar_committee_pwd_boys'] }}</td>
            <td>{{ @$data['hatbazar_committee_pwd_girls'] }}</td>
            <td>{{ @$data['hatbazar_committee_pwd_male'] }}</td>
            <td>{{ @$data['hatbazar_committee_pwd_female'] }}</td>
            <td>{{ @$data['hatbazar_committee_pwd_transgender'] }}</td>
            <td>{{ @$data['hatbazar_committee_pwd_total'] }}</td>
            <td>{{ @$data['stading_committee_boys'] }}</td>
            <td>{{ @$data['stading_committee_girls'] }}</td>

            <td>{{ @$data['stading_committee_male'] }}</td>
            <td>{{ @$data['stading_committee_female'] }}</td>
            <td>{{ @$data['stading_committee_transgender'] }}</td>
            <td>{{ @$data['stading_committee_total'] }}</td>
            <td>{{ @$data['stading_committee_pwd_boys'] }}</td>
            <td>{{ @$data['stading_committee_pwd_girls'] }}</td>
            <td>{{ @$data['stading_committee_pwd_male'] }}</td>
            <td>{{ @$data['stading_committee_pwd_female'] }}</td>
            <td>{{ @$data['stading_committee_pwd_transgender'] }}</td>
            <td>{{ @$data['stading_committee_pwd_total'] }}</td>

            <td>{{ @$data['clinic_committee_boys'] }}</td>
            <td>{{ @$data['clinic_committee_girls'] }}</td>
            <td>{{ @$data['clinic_committee_male'] }}</td>
            <td>{{ @$data['clinic_committee_female'] }}</td>
            <td>{{ @$data['clinic_committee_transgender'] }}</td>
            <td>{{ @$data['clinic_committee_total'] }}</td>
            <td>{{ @$data['clinic_committee_pwd_boys'] }}</td>
            <td>{{ @$data['clinic_committee_pwd_girls'] }}</td>
            <td>{{ @$data['clinic_committee_pwd_male'] }}</td>
            <td>{{ @$data['clinic_committee_pwd_female'] }}</td>

            <td>{{ @$data['clinic_committee_pwd_transgender'] }}</td>
            <td>{{ @$data['clinic_committee_pwd_total'] }}</td>
            <td>{{ @$data['institution_committee_boys'] }}</td>
            <td>{{ @$data['institution_committee_girls'] }}</td>
            <td>{{ @$data['institution_committee_male'] }}</td>
            <td>{{ @$data['institution_committee_female'] }}</td>
            <td>{{ @$data['institution_committee_transgender'] }}</td>
            <td>{{ @$data['institution_committee_total'] }}</td>
            <td>{{ @$data['institution_committee_pwd_boys'] }}</td>
            <td>{{ @$data['institution_committee_pwd_girls'] }}</td>

            <td>{{ @$data['institution_committee_pwd_male'] }}</td>
            <td>{{ @$data['institution_committee_pwd_female'] }}</td>
            <td>{{ @$data['institution_committee_pwd_transgender'] }}</td>
            <td>{{ @$data['institution_committee_pwd_total'] }}</td>
            <td>{{ @$data['solidarity_committee_boys'] }}</td>
            <td>{{ @$data['solidarity_committee_girls'] }}</td>
            <td>{{ @$data['solidarity_committee_male'] }}</td>
            <td>{{ @$data['solidarity_committee_female'] }}</td>
            <td>{{ @$data['solidarity_committee_transgender'] }}</td>
            <td>{{ @$data['solidarity_committee_total'] }}</td>

            <td>{{ @$data['solidarity_committee_pwd_boys'] }}</td>
            <td>{{ @$data['solidarity_committee_pwd_girls'] }}</td>
            <td>{{ @$data['solidarity_committee_pwd_male'] }}</td>
            <td>{{ @$data['solidarity_committee_pwd_female'] }}</td>
            <td>{{ @$data['solidarity_committee_pwd_transgender'] }}</td>
            <td>{{ @$data['solidarity_committee_pwd_total'] }}</td>
            <td>{{ @$data['welfare_committee_boys'] }}</td>
            <td>{{ @$data['welfare_committee_girls'] }}</td>
            <td>{{ @$data['welfare_committee_male'] }}</td>
            <td>{{ @$data['welfare_committee_female'] }}</td>

            <td>{{ @$data['welfare_committee_transgender'] }}</td>
            <td>{{ @$data['welfare_committee_total'] }}</td>
            <td>{{ @$data['welfare_committee_pwd_boys'] }}</td>
            <td>{{ @$data['welfare_committee_pwd_girls'] }}</td>
            <td>{{ @$data['welfare_committee_pwd_male'] }}</td>
            <td>{{ @$data['welfare_committee_pwd_female'] }}</td>
            <td>{{ @$data['welfare_committee_pwd_transgender'] }}</td>
            <td>{{ @$data['welfare_committee_pwd_total'] }}</td>
            
            {{-- Step 4 --}}
            <td>{{ @$data['iga_training_financial_ps_mem_boys'] }}</td>
            <td>{{ @$data['iga_training_financial_ps_mem_girls'] }}</td>
            <td>{{ @$data['iga_training_financial_ps_mem_men'] }}</td>
            <td>{{ @$data['iga_training_financial_ps_mem_women'] }}</td>
            <td>{{ @$data['iga_training_financial_ps_mem_transgender'] }}</td>
            <td>{{ @$data['iga_training_financial_ps_mem_total'] }}</td>
            <td>{{ @$data['iga_training_financial_ps_mem_pwd_boys'] }}</td>
            <td>{{ @$data['iga_training_financial_ps_mem_pwd_girls'] }}</td>
            <td>{{ @$data['iga_training_financial_ps_mem_pwd_male'] }}</td>
            <td>{{ @$data['iga_training_financial_ps_mem_pwd_women'] }}</td>
            
            <td>{{ @$data['iga_training_financial_ps_mem_pwd_transgender'] }}</td>
            <td>{{ @$data['iga_training_financial_ps_mem_pwd_total'] }}</td>
            <td>{{ @$data['iga_training_financial_without_ps_mem_boys'] }}</td>
            <td>{{ @$data['iga_training_financial_without_ps_mem_girls'] }}</td>
            <td>{{ @$data['iga_training_financial_without_ps_mem_men'] }}</td>
            <td>{{ @$data['iga_training_financial_without_ps_mem_women'] }}</td>
            <td>{{ @$data['iga_training_financial_without_ps_mem_transgender'] }}</td>
            <td>{{ @$data['iga_training_financial_without_ps_mem_total'] }}</td>
            <td>{{ @$data['iga_training_financial_without_ps_mem_pwd_boys'] }}</td>
            <td>{{ @$data['iga_training_financial_without_ps_mem_pwd_girls'] }}</td>
            
            <td>{{ @$data['iga_training_financial_without_ps_mem_pwd_male'] }}</td>
            <td>{{ @$data['iga_training_financial_without_ps_mem_pwd_women'] }}</td>
            <td>{{ @$data['iga_training_financial_without_ps_mem_pwd_transgender'] }}</td>
            <td>{{ @$data['iga_training_financial_without_ps_mem_pwd_total'] }}</td>
            <td>{{ @$data['iga_training_ps_mem_boys'] }}</td>
            <td>{{ @$data['iga_training_ps_mem_girls'] }}</td>
            <td>{{ @$data['iga_training_ps_mem_men'] }}</td>
            <td>{{ @$data['iga_training_ps_mem_women'] }}</td>
            <td>{{ @$data['iga_training_ps_mem_transgender'] }}</td>
            <td>{{ @$data['iga_training_ps_mem_total'] }}</td>
            <td>{{ @$data['iga_training_ps_mem_pwd_boys'] }}</td>
            
            <td>{{ @$data['iga_training_ps_mem_pwd_girls'] }}</td>
            <td>{{ @$data['iga_training_ps_mem_pwd_men'] }}</td>
            <td>{{ @$data['iga_training_ps_mem_pwd_women'] }}</td>
            <td>{{ @$data['iga_training_ps_mem_pwd_transgender'] }}</td>
            <td>{{ @$data['iga_training_ps_mem_pwd_total'] }}</td>
            <td>{{ @$data['iga_training_without_ps_mem_boys'] }}</td>
            <td>{{ @$data['iga_training_without_ps_mem_girls'] }}</td>
            <td>{{ @$data['iga_training_without_ps_mem_men'] }}</td>
            <td>{{ @$data['iga_training_without_ps_mem_women'] }}</td>
            <td>{{ @$data['iga_training_without_ps_mem_transgender'] }}</td>
            
            <td>{{ @$data['iga_training_without_ps_mem_total'] }}</td>
            <td>{{ @$data['iga_training_without_ps_mem_pwd_boys'] }}</td>
            <td>{{ @$data['iga_training_without_ps_mem_pwd_girls'] }}</td>
            <td>{{ @$data['iga_training_without_ps_mem_pwd_men'] }}</td>
            <td>{{ @$data['iga_training_without_ps_mem_pwd_women'] }}</td>
            <td>{{ @$data['iga_training_without_ps_mem_pwd_transgender'] }}</td>
            <td>{{ @$data['iga_training_without_ps_mem_pwd_total'] }}</td>
            
            {{-- Step 6 --}}
            <td>{{ @$data['no_of_session_with_men'] }}</td>
            <td>{{ @$data['session_with_men_total'] }}</td>
            <td>{{ @$data['session_with_men_pwd_total'] }}</td>
            <td>{{ @$data['no_of_session_with_women'] }}</td>
            <td>{{ @$data['session_with_women_total'] }}</td>
            <td>{{ @$data['session_with_women_pwd_total'] }}</td>
            <td>{{ @$data['no_of_session_with_adolescent'] }}</td>
            <td>{{ @$data['session_with_adolescent_boys'] }}</td>
            <td>{{ @$data['session_with_adolescent_girls'] }}</td>
            <td>{{ @$data['session_with_adolescent_total'] }}</td>
            <td>{{ @$data['session_with_adolescent_pwd_total'] }}</td>
            <td>{{ @$data['no_of_session_with_ps'] }}</td>
            <td>{{ @$data['session_with_ps_boys'] }}</td>
            <td>{{ @$data['session_with_ps_girls'] }}</td>

            <td>{{ @$data['session_with_ps_men'] }}</td>
            <td>{{ @$data['session_with_ps_women'] }}</td>
            <td>{{ @$data['session_with_ps_transgender'] }}</td>
            <td>{{ @$data['session_with_ps_pwd'] }}</td>
            <td>{{ @$data['session_with_ps_total'] }}</td>
            <td>{{ @$data['capacity_building_training_by_selp_boy'] }}</td>
            <td>{{ @$data['capacity_building_training_by_selp_girls'] }}</td>
            <td>{{ @$data['capacity_building_training_by_selp_men'] }}</td>
            <td>{{ @$data['capacity_building_training_by_selp_women'] }}</td>
            <td>{{ @$data['capacity_building_training_by_selp_transgender'] }}</td>
            <td>{{ @$data['capacity_building_training_by_selp_total'] }}</td>

            <td>{{ @$data['capacity_building_training_by_selp_boy_pwd'] }}</td>
            <td>{{ @$data['capacity_building_training_by_selp_girls_pwd'] }}</td>
            <td>{{ @$data['capacity_building_training_by_selp_men_pwd'] }}</td>
            <td>{{ @$data['capacity_building_training_by_selp_women_pwd'] }}</td>
            <td>{{ @$data['capacity_building_training_by_selp_girls_transgender'] }}</td>
            <td>{{ @$data['capacity_building_training_by_selp_pwd_total'] }}</td>
            
            
            {{-- Step 7 --}}
            {{-- <td>{{ @$pollisomaj['womens_day_celebration_boys'] }}</td>
            <td>{{ @$pollisomaj['womens_day_celebration_girls'] }}</td>
            <td>{{ @$pollisomaj['womens_day_celebration_men'] }}</td>
            <td>{{ @$pollisomaj['womens_day_celebration_women'] }}</td>
            <td>{{ @$pollisomaj['womens_day_celebration_transgender'] }}</td>
            <td>{{ @$pollisomaj['womens_day_celebration_total'] }}</td>
            <td>{{ @$pollisomaj['womens_day_celebration_date'] }}</td>
            <td>{{ @$pollisomaj['womens_day_celebration_pwd_boys'] }}</td>
            <td>{{ @$pollisomaj['womens_day_celebration_pwd_girls'] }}</td>
            <td>{{ @$pollisomaj['womens_day_celebration_pwd_men'] }}</td>
            <td>{{ @$pollisomaj['womens_day_celebration_pwd_women'] }}</td>
            <td>{{ @$pollisomaj['womens_day_celebration_pwd_transgender'] }}</td>
            <td>{{ @$pollisomaj['womens_day_celebration_pwd_total'] }}</td>
            <td>{{ @$pollisomaj['celebration_days_campaign_boys'] }}</td>
            <td>{{ @$pollisomaj['celebration_days_campaign_girls'] }}</td>
            <td>{{ @$pollisomaj['celebration_days_campaign_men'] }}</td>
            <td>{{ @$pollisomaj['celebration_days_campaign_women'] }}</td>
            <td>{{ @$pollisomaj['celebration_days_campaign_transgender'] }}</td>
            <td>{{ @$pollisomaj['celebration_days_campaign_total'] }}</td>
            <td>{{ @$pollisomaj['celebration_days_campaign_date'] }}</td>
            <td>{{ @$pollisomaj['celebration_days_campaign_pwd_boys'] }}</td>
            <td>{{ @$pollisomaj['celebration_days_campaign_pwd_girls'] }}</td>
            <td>{{ @$pollisomaj['celebration_days_campaign_pwd_men'] }}</td>
            <td>{{ @$pollisomaj['celebration_days_campaign_pwd_women'] }}</td>
            <td>{{ @$pollisomaj['celebration_days_campaign_pwd_transgender'] }}</td>
            <td>{{ @$pollisomaj['celebration_days_campaign_pwd_total'] }}</td>
            <td>{{ @$pollisomaj['legal_aid_days_boys'] }}</td>
            <td>{{ @$pollisomaj['legal_aid_days_girls'] }}</td>
            <td>{{ @$pollisomaj['legal_aid_days_men'] }}</td>
            <td>{{ @$pollisomaj['legal_aid_days_women'] }}</td>
            <td>{{ @$pollisomaj['legal_aid_days_transgender'] }}</td>
            <td>{{ @$pollisomaj['legal_aid_days_total'] }}</td>
            <td>{{ @$pollisomaj['legal_aid_days_date'] }}</td>
            <td>{{ @$pollisomaj['legal_aid_days_pwd_boys'] }}</td>
            <td>{{ @$pollisomaj['legal_aid_days_pwd_girls'] }}</td>
            <td>{{ @$pollisomaj['legal_aid_days_pwd_men'] }}</td>
            <td>{{ @$pollisomaj['legal_aid_days_pwd_women'] }}</td>
            <td>{{ @$pollisomaj['legal_aid_days_pwd_transgender'] }}</td>
            <td>{{ @$pollisomaj['legal_aid_days_pwd_total'] }}</td> --}}
            
            {{-- Step 8 --}}
            {{-- <td>{{ @$pollisomaj['social_cohesion_event'] }}</td>
            <td>{{ @$pollisomaj['social_cohesion_event_date'] }}</td>
            <td>{{ @$pollisomaj['social_cohesion_event_participent_girl'] }}</td>
            <td>{{ @$pollisomaj['social_cohesion_event_participent_boy'] }}</td>
            <td>{{ @$pollisomaj['social_cohesion_event_participent_women'] }}</td>
            <td>{{ @$pollisomaj['social_cohesion_event_participent_men'] }}</td>
            <td>{{ @$pollisomaj['social_cohesion_event_participent_transgender'] }}</td>
            <td>{{ @$pollisomaj['social_cohesion_event_participent_total'] }}</td>
            <td>{{ @$pollisomaj['upazila_stakeholder_meeting'] }}</td>
            <td>{{ @$pollisomaj['upazila_stakeholder_meeting_date'] }}</td>
            <td>{{ @$pollisomaj['upazila_stakeholder_meeting_participent_men_gob'] }}</td>
            <td>{{ @$pollisomaj['upazila_stakeholder_meeting_participent_women_gob'] }}</td>
            <td>{{ @$pollisomaj['upazila_stakeholder_meeting_participent_boy'] }}</td>
            <td>{{ @$pollisomaj['upazila_stakeholder_meeting_participent_girl'] }}</td>
            <td>{{ @$pollisomaj['upazila_stakeholder_meeting_participent_men'] }}</td>
            <td>{{ @$pollisomaj['upazila_stakeholder_meeting_participent_women'] }}</td>
            <td>{{ @$pollisomaj['upazila_stakeholder_meeting_participent_transgender'] }}</td>
            <td>{{ @$pollisomaj['upazila_stakeholder_meeting_participent_total'] }}</td>
            <td>{{ @$pollisomaj['upazila_stakeholder_meeting_participent_pwd_boy'] }}</td>
            <td>{{ @$pollisomaj['upazila_stakeholder_meeting_participent_pwd_girl'] }}</td>
            <td>{{ @$pollisomaj['upazila_stakeholder_meeting_participent_pwd_men'] }}</td>
            <td>{{ @$pollisomaj['upazila_stakeholder_meeting_participent_pwd_women'] }}</td>
            <td>{{ @$pollisomaj['upazila_stakeholder_meeting_participent_pwd_transgender'] }}</td>
            <td>{{ @$pollisomaj['upazila_stakeholder_meeting_participent_pwd_total'] }}</td> --}}
            
            {{-- Step 9 --}}
            {{-- <td>{{ @$pollisomaj['panel_staff_workshop'] }}</td>
            <td>{{ @$pollisomaj['panel_staff_date'] }}</td>
            <td>{{ @$pollisomaj['panel_lawyer'] }}</td>
            <td>{{ @$pollisomaj['panel_lawyer_date'] }}</td>
            <td>{{ @$pollisomaj['external_network_dlac_meeting'] }}</td>
            <td>{{ @$pollisomaj['external_network_dlac_meeting_male'] }}</td>
            <td>{{ @$pollisomaj['external_network_dlac_meeting_female'] }}</td>
            <td>{{ @$pollisomaj['external_network_dlac_meeting_total'] }}</td>
            <td>{{ @$pollisomaj['external_network_dlac_meeting_date'] }}</td>
            <td>{{ @$pollisomaj['pt_group'] }}</td>
            <td>{{ @$pollisomaj['pt_group_performer_boy'] }}</td>
            <td>{{ @$pollisomaj['pt_group_performer_girl'] }}</td>
            <td>{{ @$pollisomaj['pt_group_performer_men'] }}</td>
            <td>{{ @$pollisomaj['pt_group_performer_women'] }}</td>
            <td>{{ @$pollisomaj['pt_group_performer_transgender'] }}</td>
            <td>{{ @$pollisomaj['pt_group_performer_total'] }}</td>
            <td>{{ @$pollisomaj['pt_group_performer_boy_pwd'] }}</td>
            <td>{{ @$pollisomaj['pt_group_performer_girl_pwd'] }}</td>
            <td>{{ @$pollisomaj['pt_group_performer_men_pwd'] }}</td>
            <td>{{ @$pollisomaj['pt_group_performer_women_pwd'] }}</td>
            <td>{{ @$pollisomaj['pt_group_performer_transgender_pwd'] }}</td>
            <td>{{ @$pollisomaj['pt_group_performer_transgender_pwd_total'] }}</td> --}}
            
            {{-- Step 9 --}}
            {{-- <td>{{ @$pollisomaj['production_workshop_spa'] }}</td>
            <td>{{ @$pollisomaj['production_workshop_cost_recovery'] }}</td>
            <td>{{ @$pollisomaj['production_workshop_project'] }}</td>
            <td>{{ @$pollisomaj['production_workshop_special'] }}</td>
            <td>{{ @$pollisomaj['production_workshop_other'] }}</td> --}}
        </tr>
            @endforeach
    </tbody>
</table>
