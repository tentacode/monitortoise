describe('landing page', () => {
  it('contains the proper content', () => {
    cy.visit('/')

    cy.contains('The best tech watch of your LIFE BB.')
  })
})