var fields = [
  {
    key: 'suffix',
    type: 'input',
    required: true,
    templateOptions: {
      label: 'suffix'
    }
  },
  {
    key: 'club',
    type: 'ntm-select',
    optionsApi: 'clubs',
    templateOptions: {
      label: 'club'
    }
  },
  {
    key: 'group',
    type: 'ntm-select',
    options: [],
    templateOptions: {
      label: 'group'
    }
  },
  {
    key: 'out_of_competition',
    type: 'boolean',
    templateOptions: {
      label: 'outOfCompetition'
    }
  },
  {
    key: 'players',
    type: 'ntm-multicheck',
    templateOptions: {
      options: [],
      label: 'players'
    }
  }
]

export default fields
