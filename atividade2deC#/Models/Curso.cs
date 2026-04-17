namespace ProjetoProfessorCurso.Models;

public class Curso
{
    public int Id { get; set; }
    public string Nome { get; set; } = string.Empty;

    public int ProfessorId { get; set; }

    public Professor Professor { get; set; } = null!;
}
