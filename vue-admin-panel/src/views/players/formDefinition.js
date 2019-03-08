var fields = [
  {
    key: 'firstName',
    type: 'input',
    required: true,
    templateOptions: {
      label: 'firstName'
    }
  },
  {
    key: 'lastName',
    type: 'input',
    templateOptions: {
      label: 'lastName'
    }
  },
  {
    key: 'middleName',
    type: 'input',
    templateOptions: {
      label: 'middleName'
    }
  },

  {
    key: 'email',
    type: 'input',
    templateOptions: {
      inputType: 'email',
      label: 'email'
    }
  },
  {
    key: 'birthDate',
    type: 'datepicker',
    templateOptions: {
      label: 'birthDate'
    }
  },
  {
    key: 'club',
    type: 'ntm-select',
    optionsApi: 'clubs',
    templateOptions: {
      label: 'club'
    }
  }
]

export default fields
