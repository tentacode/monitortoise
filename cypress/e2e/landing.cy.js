describe('landing page', () => {
  it('display symfony version', () => {
    cy.visit('/', {
      failOnStatusCode: false
    })

    cy.contains('Welcome to Symfony 7')
  })
})