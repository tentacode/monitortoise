describe('landing page', () => {
  it('display symfony version', () => {
    cy.visit('/')

    cy.contains('🐢 Monitortoise landing page')
  })
})