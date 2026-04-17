using System;
using System.Collections.Generic;
using System.Linq;

public class Professor
{
    public int Id { get; set; }
    public string Nome { get; set; }
    // Um Professor tem muitos Cursos (1:N)
    public List<Curso> Cursos { get; set; } = new List<Curso>();
}

public class Curso
{
    public int Id { get; set; }
    public string Nome { get; set; }
    public int ProfessorId { get; set; }
    // Propriedade de Navegação
    public Professor Professor { get; set; }
}

public class InstituicaoService
{
    private List<Professor> _professores = new List<Professor>();

    public void CadastrarProfessor(Professor prof)
    {
        _professores.Add(prof);
    }

    public List<Professor> ListarProfessoresComCursos()
    {
        return _professores;
    }
}

class Program
{
    static void Main()
    {
        var service = new InstituicaoService();

        var prof1 = new Professor { Id = 1, Nome = "Dr. Hans Chucrute" };
        
        var c1 = new Curso { Id = 101, Nome = "Física Quântica", ProfessorId = prof1.Id, Professor = prof1 };
        var c2 = new Curso { Id = 102, Nome = "Termodinâmica", ProfessorId = prof1.Id, Professor = prof1 };

        prof1.Cursos.Add(c1);
        prof1.Cursos.Add(c2);

        service.CadastrarProfessor(prof1);

        Console.WriteLine("=== Relatório de Professores e seus Cursos ===");
        var lista = service.ListarProfessoresComCursos();

        foreach (var prof in lista)
        {
            Console.WriteLine($"Professor: {prof.Nome}");
            
            if (prof.Cursos.Any())
            {
                foreach (var curso in prof.Cursos)
                {
                    Console.WriteLine($"  -> Curso: {curso.Nome} (ID: {curso.Id})");
                }
            }
            else
            {
                Console.WriteLine("  -> Nenhum curso vinculado.");
            }
            Console.WriteLine();
        }
    }
}
