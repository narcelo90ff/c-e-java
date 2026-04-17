namespace ProjetoProfessorCurso.Models;

public class Curso
{
    public int Id { get; set; }
    public string Nome { get; set; } = string.Empty;

    // Chave estrangeira
    public int ProfessorId { get; set; }

    // Propriedade de navegação
    public Professor Professor { get; set; } = null!;
}
