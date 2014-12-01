<?php 

return array(
  'fields'=>array(
    'FirstName'=>array(
      'title'=>'First Name',
      'required'=>true,
      'type'=>'text',
      'options'=>array(
        'placeholder'=>'First Name'
      )
    ),
    'LastName'=>array(
      'title'=>'Last Name',
      'required'=>true,
      'type'=>'text',
      'options'=>array(
        'placeholder'=>'Last Name'
      )
    ),
    'Email'=>array(
      'title'=>'Email Address',
      'required'=>true,
      'type'=>'email',
      'options'=>array(
        'placeholder'=>'Email Address'
      )
    ),
    'Phone'=>array(
      'title'=>'Phone Number',
      'required'=>true,
      'type'=>'tel',
      'options'=>array(
        'placeholder'=>'Contact Number'
      )
    ),
    'TimeZoneId'=>array(
      'title'=>'Time Zone',
      'required'=>false,
      'type'=>'select',
      'default'=>'(UTC-07:00) Mountain Time (US & Canada)',
      'reference'=>'TimeZones',
      'reference_type'=>'TimeZone'
    ),
    'InstitutionProfileId'=>array(
      'title'=>'University',
      'type'=>'select',
      'reference'=>'Institutions',
      'reference_type'=>'Institution'
    ),
    'InterestTerm'=>array(
      'title'=>'Term of Interest',
      'required'=>false,
      'type'=>'select',
      'reference'=>'TermTypes',
      'reference_type'=>'TermType'
    ),
    'InterestYear'=>array(
      'title'=>'Interest Year',
      'required'=>false,
      'type'=>'text'
    ),
    'CountryOfInterest1Id'=>array(
      'title'=>'Country of Interest',
      'required'=>false,
      'type'=>'select',
      'reference'=>'OrganizationCountries',
      'reference_type'=>'OrganizationCountry'
    ),
    'ProgramOfInterest1Id'=>array(
      'title'=>'Program Of Interest',
      'required'=>false,
      'type'=>'select',
      'reference'=>'Programs',
      'reference_type'=>'Program'
    ),
    'Question'=>array(
      'title'=>'Question',
      'required'=>false,
      'type'=>'textarea'
    ),
  )
);