describe('link preview', () => {
    beforeEach(() => {
        cy.login('gabriel@tentacode.test')

        cy.visit('/add-link')
    })

    it('can preview a link', () => {
        cy.findByTestId('add_link_input').type('https://tentacode.dev/ma-mission-ideale')

        cy.contains('💖 Ma mission idéale 💖');
        cy.contains("Bonjour à vous et merci de l'intérêt que vous portez à mon profil !");
    })
  })